<?php

namespace App\Http\Controllers\Admin;


use App\Http\Filters\OrderFilter;
use App\Models\Ayar;
use App\Models\Log;
use App\Models\Product\Urun;
use App\Models\Product\UrunFirma;
use App\Models\SepetUrun;
use App\Models\Siparis;
use App\Notifications\order\OrderCancelledNotification;
use App\Notifications\order\OrderItemStatusChangedNotification;
use App\Notifications\order\OrderStatusChangedNotification;
use App\Repositories\Interfaces\CityTownInterface;
use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\SepetInterface;
use App\Repositories\Interfaces\SiparisInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Iyzipay\Model\Locale;
use Yajra\DataTables\DataTables;

class SiparisController extends Controller
{
    use SiparisUrunTrait, ResponseTrait;

    protected SiparisInterface $model;
    protected UrunFirma $productCompanyService;
    protected KategoriInterface $categoryService;
    protected CityTownInterface $cityTownService;
    protected SepetInterface $basketService;

    public function __construct(SiparisInterface $model, UrunFirma $productCompanyService, KategoriInterface $categoryService, CityTownInterface $cityTownService, SepetInterface $basketService)
    {
        $this->model = $model;
        $this->productCompanyService = $productCompanyService;
        $this->categoryService = $categoryService;
        $this->cityTownService = $cityTownService;
        $this->basketService = $basketService;
    }


    public function list()
    {
        $filter_types = Siparis::listStatusWithId();
        $companies = $this->productCompanyService->all();
        $categories = $this->categoryService->all([['parent_category_id', null]], ['id', 'title', 'parent_category_id'], ['sub_categories']);
        $states = $this->cityTownService->all();


        return view('admin.order.list_orders', compact('filter_types', 'companies', 'categories', 'states'));
    }

    /**
     * @param Siparis $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newOrEditOrder(Siparis $order)
    {
        if ($order->is_payment == 0) {
            error("Dikkat bu işlem 3D security kısmını geçememiştir.Ödeme İşlemi gerçekleşmemiştir");
        }
        $logs = $this->getOrderAllLogs($order->id, $order->sepet_id);
        $filter_types = Siparis::listStatusWithId();
        $item_filter_types = SepetUrun::listStatusWithId();
        $basket = $order->basket;
        $currencySymbol = Ayar::getCurrencySymbolById($order->currency_id);
        return view('admin.order.new_edit_order', compact('order', 'filter_types', 'item_filter_types', 'logs', 'basket', 'currencySymbol'));
    }

    public function save(Request $request, Siparis $order)
    {
        $status = $request->get('status');
        $this->checkBasketItemsStatus($request, $order);
        $orderStatus = $order->status;

        $order->update(['status' => $request->get('status')]);

        if ($status != $orderStatus) {
            $order->basket->user->notify(new OrderStatusChangedNotification($order));
        }

        return redirect(route('admin.order.edit', $order->id))->with('message', 'işlem başarılı');
    }

    /**
     * @param OrderFilter $filter
     * @return mixed
     * @throws \Exception
     */
    public function ajax(OrderFilter $filter)
    {
        return DataTables::of(
            Siparis::with(['basket' => function ($query) {
                    $query->withTrashed();
                }, 'delivery_address' => function ($query) {
                    $query->select(['id', 'title', 'state_id', 'district_id'])->with(['state', 'district'])->withTrashed();
                }, 'basket.user:id,name,surname,email']
            )->filter($filter)
        )->make(true);

    }


    public function deleteOrder($id)
    {
        //$this->model->delete($id);
        return redirect(route('admin.orders'));
    }

    /**
     * sipariş oluşturulurken sepetteki ürünlerin kopyası alınır
     * @param Siparis $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function snapshot(Siparis $order)
    {
        return response()->json($order->snapshot);
    }


    public function invoiceDetail(Siparis $order)
    {
        return view('site.siparis.invoice.invoiceDetail', compact('order'));
    }


    /**
     * tüm siparişi iyzicodan iptal eder
     * @param Siparis $order
     */
    public function cancelOrder(Siparis $order)
    {
        $canCancelResponse = $this->model->checkCanCancelAllOrderFromAdmin($order);
        if (!$canCancelResponse['status']) {
            return back()->withErrors($canCancelResponse['message']);
        }
        $response = $this->model->cancelOrderFromIyzico($order, Locale::TR);
        if ($response['status'] == "failure") {
            Log::addIyzicoLog(__('log.admin.error_when_order_cancel'), json_encode($response), $order->id, Log::TYPE_ORDER);
            return back()->withErrors($response['errorMessage']);
        }
        $order->update(['status' => Siparis::STATUS_IPTAL_EDILDI]);
        $this->basketService->cancelBasketItems($order);
        Log::addIyzicoLog(__('log.admin.order_successfully_cancelled_from_admin'), json_encode($response), $order->id, Log::TYPE_ORDER);
        $order->notify(new OrderCancelledNotification($order));
        success(__('log.admin.order_successfully_cancelled_message'));

        return back();
    }

    /**
     * tüm siparişi iyzicodan iptal eder
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refundItem(Request $request)
    {
        $basketItem = SepetUrun::withTrashed()->find($request->get('id'));
        $validated = $request->validate(['refundAmount' => 'required|numeric|between:0,' . $basketItem->refundable_amount, 'id' => 'required|numeric']);
        $refundAmount = (float)$validated['refundAmount'];
        $canRefundResponse = $this->model->checkCanRefundBasketItemFromAdmin($basketItem, $refundAmount);
        if (!$canRefundResponse['status']) {
            return back()->withErrors($canRefundResponse['message']);
        }
        $iyzicoResponse = $this->model->refundBasketItemFromIyzico($basketItem, $refundAmount);
        if ($iyzicoResponse['status']) {
            Log::addIyzicoLog(__('log.admin.order_item_successfully_refunded_message', ['id' => $basketItem->id, 'refundAmount' => $refundAmount]), json_encode($canRefundResponse), $basketItem->sepet_id);
            success($iyzicoResponse['message']);
        } else {
            error($iyzicoResponse['message']);
        }

        return back();
    }

}
