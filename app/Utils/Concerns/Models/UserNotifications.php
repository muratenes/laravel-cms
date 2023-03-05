<?php

namespace App\Utils\Concerns\Models;

use App\Models\Order;
use App\Notifications\order\OrderCreatedNotification;

trait UserNotifications
{
    /**
     * @param Order $order
     */
    public function sendOrderCreatedNotification(Order $order)
    {
        $this->notify(new OrderCreatedNotification());
    }
}
