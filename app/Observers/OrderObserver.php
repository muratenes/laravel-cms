<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\SepetUrun;
use App\Models\Siparis;

class OrderObserver
{
    public function updating(Siparis $order)
    {
        $dirty = $order->getDirty();
        if (isset($dirty['status'])) {
            $statusText = SepetUrun::statusLabelStatic($dirty['status']);
            Log::addLog(sprintf("sipariş durumu '%s' olarak güncellendi", $statusText), json_encode($dirty), Log::TYPE_ORDER_UPDATE, $order->id);
        } else {
            Log::addLog('sipariş güncellendi', json_encode($dirty), Log::TYPE_ORDER_UPDATE, $order->id);
        }
    }
}
