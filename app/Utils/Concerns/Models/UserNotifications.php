<?php

namespace App\Utils\Concerns\Models;

use App\Models\Siparis;
use App\Notifications\order\OrderCreatedNotification;

trait UserNotifications
{
    /**
     * @param Siparis $order
     */
    public function sendOrderCreatedNotification(Siparis $order)
    {
        $this->notify(new OrderCreatedNotification());
    }
}
