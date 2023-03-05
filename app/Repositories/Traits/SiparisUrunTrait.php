<?php

namespace App\Repositories\Traits;

use App\Models\Basket;
use App\Models\Log;
use App\Models\Order;
use App\Notifications\order\OrderItemStatusChangedNotification;
use Illuminate\Http\Request;

trait SiparisUrunTrait
{
    /**
     * sipariş ile ilgili tüm log kayıtlarını getirir.
     *
     * @param $orderId
     * @param $basketId
     *
     * @return mixed
     */
    protected function getOrderAllLogs($orderId, $basketId)
    {
        return Log::whereIn('type', [Log::TYPE_ORDER, Log::TYPE_BASKET])
            ->whereIn('code', [$orderId, $basketId])
            ->orderByDesc('id')->get();
    }

    /**
     * basket ürün statusleri günceller.
     *
     * @param Request $request
     * @param Order   $order
     */
    protected function checkBasketItemsStatus(Request $request, Order $order)
    {
        foreach ($order->basket->basket_items as $item) {
            $status = $request->get("orderItem{$item->id}");
            if ($item->status !== $status && $status) {
                $item->update(['status' => $status]);
                $order->basket->user->notify(new OrderItemStatusChangedNotification($order, $item));
            }
        }
    }
}
