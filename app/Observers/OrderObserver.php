<?php

namespace App\Observers;

use App\Models\BasketItem;
use App\Models\Log;
use App\Models\Order;

class OrderObserver
{
    public function updating(Order $order)
    {
        $dirty = $order->getDirty();
        if (isset($dirty['status'])) {
            $statusText = BasketItem::statusLabelStatic($dirty['status']);
            Log::addLog(sprintf("sipariş durumu '%s' olarak güncellendi", $statusText), json_encode($dirty), Log::TYPE_ORDER_UPDATE, $order->id);
        } else {
            Log::addLog('sipariş güncellendi', json_encode($dirty), Log::TYPE_ORDER_UPDATE, $order->id);
        }
    }
}
