<?php

namespace App\Repositories\Traits;

use App\Models\Log;
use App\Models\Sepet;
use App\Models\Siparis;
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
     * sepet ürün statusleri günceller.
     *
     * @param Request $request
     * @param Siparis $order
     */
    protected function checkBasketItemsStatus(Request $request, Siparis $order)
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
