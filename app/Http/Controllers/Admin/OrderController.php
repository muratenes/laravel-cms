<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\OrderFilter;
use App\Models\BasketItem;
use App\Models\Cargo;
use App\Models\Config;
use App\Models\Log;
use App\Models\Order;
use App\Models\Product\ProductCompany;
use App\Notifications\order\OrderCancelledNotification;
use App\Notifications\order\OrderStatusChangedNotification;
use App\Repositories\Interfaces\BasketInterface;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\CityTownInterface;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use Illuminate\Http\Request;
use Iyzipay\Model\Locale;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    use ResponseTrait;
    use SiparisUrunTrait;

    protected OrderInterface $model;
    protected ProductCompany $productCompanyService;
    protected CategoryInterface $categoryService;
    protected CityTownInterface $cityTownService;
    protected BasketInterface $basketService;

    public function __construct(OrderInterface $model, ProductCompany $productCompanyService, CategoryInterface $categoryService, CityTownInterface $cityTownService, BasketInterface $basketService)
    {
        $this->model = $model;
        $this->productCompanyService = $productCompanyService;
        $this->categoryService = $categoryService;
        $this->cityTownService = $cityTownService;
        $this->basketService = $basketService;
    }

    public function list()
    {
        $filter_types = Order::listStatusWithId();
        $companies = $this->productCompanyService->all();
        $categories = $this->categoryService->all([['parent_category_id', null]], ['id', 'title', 'parent_category_id'], ['sub_categories']);
        $states = $this->cityTownService->all();

        return view('admin.order.list_orders', compact('filter_types', 'companies', 'categories', 'states'));
    }

    /**
     * @param int $orderId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newOrEditOrder(int $orderId)
    {
        $order = $this->getOrderWithTrashed($orderId);
        // todo : dil dosyasından getir
        if (0 === $order->is_payment) {
            error('Dikkat bu işlem 3D security kısmını geçememiştir.Ödeme İşlemi gerçekleşmemiştir');
        }

        return view('admin.order.new_edit_order', [
            'logs'              => $this->getOrderAllLogs($order->id, $order->basket_id),
            'filter_types'      => Order::listStatusWithId(),
            'item_filter_types' => BasketItem::listStatusWithId(),
            'order'             => $order,
            'cargos'            => Cargo::all(),
            'currencySymbol'    => Config::getCurrencySymbolById($order->currency_id), ]);
    }

    public function save(Request $request, $orderId)
    {
        $order = $this->getOrderWithTrashed($orderId);
        $validated = $request->validate(['status' => 'nullable|numeric', 'cargo_id' => 'numeric|nullable', 'cargo_code' => 'string|nullable|max:100']);
        $status = $request->get('status');
        $this->checkBasketItemsStatus($request, $order);
        $orderStatus = $order->status;

        $order->update($validated);

        if ($status !== $orderStatus) {
            $order->basket->user->notify(new OrderStatusChangedNotification($order));
        }

        return redirect(route('admin.order.edit', $order->id))->with('message', 'işlem başarılı');
    }

    /**
     * @param OrderFilter $filter
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function ajax(OrderFilter $filter)
    {
        return DataTables::of(
            Order::with(
                ['basket' => function ($query) {
                    $query->withTrashed();
                }, 'delivery_address' => function ($query) {
                    $query->select(['id', 'title', 'state_id', 'district_id'])->with(['state', 'district'])->withTrashed();
                }, 'basket.user:id,name,surname,email']
            )->filter($filter)
        )->make(true);
    }

    public function deleteOrder($id)
    {
        // $this->model->delete($id);
        return redirect(route('admin.orders'));
    }

    /**
     * sipariş oluşturulurken sepetteki ürünlerin kopyası alınır.
     *
     * @param Order $order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function snapshot(Order $order)
    {
        return response()->json($order->snapshot);
    }

    public function invoiceDetail(Order $order)
    {
        return view('site.order.invoice.invoiceDetail', compact('order'));
    }

    /**
     * tüm siparişi iyzicodan iptal eder.
     *
     * @param Order $order
     */
    public function cancelOrder(Order $order)
    {
        $canCancelResponse = $this->model->checkCanCancelAllOrderFromAdmin($order);
        if (! $canCancelResponse['status']) {
            return back()->withErrors($canCancelResponse['message']);
        }
        $response = $this->model->cancelOrderFromIyzico($order, Locale::TR);
        if ('failure' === $response['status']) {
            Log::addIyzicoLog(__('log.admin.error_when_order_cancel'), json_encode($response), $order->id, Log::TYPE_ORDER);

            return back()->withErrors($response['errorMessage']);
        }
        $order->update(['status' => Order::STATUS_IPTAL_EDILDI]);
        $this->basketService->cancelBasketItems($order);
        Log::addIyzicoLog(__('log.admin.order_successfully_cancelled_from_admin'), json_encode($response), $order->id, Log::TYPE_ORDER);
        $order->notify(new OrderCancelledNotification($order));
        success(__('log.admin.order_successfully_cancelled_message'));

        return back();
    }

    /**
     * tüm siparişi iyzicodan iptal eder.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refundItem(Request $request)
    {
        $basketItem = BasketItem::withTrashed()->find($request->get('id'));
        $validated = $request->validate(['refundAmount' => 'required|numeric|between:0,' . $basketItem->refundable_amount, 'id' => 'required|numeric']);
        $refundAmount = (float) $validated['refundAmount'];
        $canRefundResponse = $this->model->checkCanRefundBasketItemFromAdmin($basketItem, $refundAmount);
        if (! $canRefundResponse['status']) {
            return back()->withErrors($canRefundResponse['message']);
        }
        $iyzicoResponse = $this->model->refundBasketItemFromIyzico($basketItem, $refundAmount);
        if ($iyzicoResponse['status']) {
            Log::addIyzicoLog(__('log.admin.order_item_successfully_refunded_message', ['id' => $basketItem->id, 'refundAmount' => $refundAmount]), json_encode($canRefundResponse), $basketItem->basket_id);
            success($iyzicoResponse['message']);
        } else {
            error($iyzicoResponse['message']);
        }

        return back();
    }

    /**
     *  siparişin silinmiş relationları ile birlikte getirir.
     *
     * @param $orderId
     *
     * @return null|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function getOrderWithTrashed($orderId)
    {
        return Order::with(['basket' => function ($query) {
            $query->withTrashed();
        }, 'basket.basket_items' => function ($query) {
            $query->withTrashed();
        }, 'basket.basket_items.product' => function ($query) {
            $query->withTrashed();
        }])->find($orderId);
    }
}
