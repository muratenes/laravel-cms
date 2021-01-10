<?php

namespace App\Http\Controllers\Admin;


use App\Models\Ayar;
use App\Models\Log;
use App\Models\SepetUrun;
use App\Models\Siparis;
use App\Notifications\order\OrderCancelledNotification;
use App\Notifications\order\OrderItemStatusChangedNotification;
use App\Notifications\order\OrderStatusChangedNotification;
use App\Repositories\Interfaces\SiparisInterface;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Iyzipay\Model\Locale;

class SiparisController extends Controller
{
    use SiparisUrunTrait, ResponseTrait;

    protected SiparisInterface $model;

    public function __construct(SiparisInterface $model)
    {
        $this->model = $model;
    }


    public function list(Request $request)
    {
        $request->validate(['status_filter' => 'numeric']);
        $query = $request->get('q');
        $status_filter = $request->get('status_filter');
        if ($query || $status_filter) {
            $list = $this->model->orderFilterByStatusAndSearchText($query, $status_filter, true);
        } else {
            $list = $this->model->with('basket.user', null, true);
        }
        $filter_types = Siparis::listStatusWithId();
        return view('admin.order.list_orders', compact('list', 'filter_types'));
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
     * ürün iptal etmek için aynı gün içinde saat 5'ten önce
     * @param SepetUrun $item
     * @return array
     */
    public function cancelOrderItem(SepetUrun $item)
    {
        return $this->model->refundBasketItemFromIyzico($item);
    }

    /**
     * tüm siparişi iyzicodan iptal eder
     * @param Siparis $order
     */
    public function cancelOrder(Siparis $order)
    {
        $canCancelResponse = $this->model->checkCanCancelAllOrder($order);
//        if (!$canCancelResponse['status']) {
//            return back()->withErrors($canCancelResponse['message']);
//        }
        $response = $this->model->cancelOrderFromIyzico($order, Locale::TR);
        if ($response['status'] == "failure") {
            Log::addIyzicoLog(__('log.admin.error_when_order_cancel'), json_encode($response), $order->id, Log::TYPE_ORDER);
            return back()->withErrors($response['errorMessage']);
        }
        $order->update(['status' => Siparis::STATUS_IPTAL_EDILDI]);
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
        $request->validate(['refundAmount' => 'required|numeric', 'id' => 'required|numeric']);
        $refundAmount = (float)$request->get('refundAmount');
        $item = SepetUrun::find($request->get('id'));
        // todo : sadece kullanıcı için kontrol et
        $canRefundResponse = $this->model->checkCanRefundBasketItem($item, $refundAmount);
        if (!$canRefundResponse['status']) {
            return back()->withErrors($canRefundResponse['message']);
        }
        $iyzicoResponse = $this->model->refundBasketItemFromIyzico($item, $refundAmount);
        $iyzicoResponse['status'] ? success($iyzicoResponse['message']) : error($iyzicoResponse['message']);
        Log::addIyzicoLog(__('log.admin.order_item_successfully_refunded_message', ['id' => $item->id, 'refundAmount' => $refundAmount]), json_encode($canRefundResponse), $item->sepet_id);

        return back();
    }

}
