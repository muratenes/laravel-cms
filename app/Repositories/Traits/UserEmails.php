<?php

namespace App\Repositories\Traits;

use App\Mail\OrderStatusOnChangedMail;
use App\Models\BasketItem;
use App\Models\Order;
use App\Notifications\PasswordReset;

trait UserEmails
{
    /**
     * parola sıfırlama isteği gönderir.
     *
     * @param $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    /**
     * sepetteki ürün status değişince kullanıcıya notify gider.
     *
     * @param Order      $order
     * @param BasketItem $basketItem
     */
    public function orderItemStatusChanged(Order $order, BasketItem $basketItem)
    {
        $this->notify(new OrderItemStatusChangedNotification($order, $basketItem));
    }

    /**
     * Basket status değişince kullanıcıya notify gider.
     *
     * @param Order      $order
     * @param BasketItem $basketItem
     */
    public function orderStatusChangedNotification(Order $order)
    {
        $this->notify(new OrderStatusOnChangedMail($this, $order));
    }
}
