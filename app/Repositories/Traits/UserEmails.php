<?php

namespace App\Repositories\Traits;

use App\Mail\OrderStatusOnChangedMail;
use App\Models\SepetUrun;
use App\Models\Siparis;
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
     * @param Siparis   $order
     * @param SepetUrun $basketItem
     */
    public function orderItemStatusChanged(Siparis $order, SepetUrun $basketItem)
    {
        $this->notify(new OrderItemStatusChangedNotification($order, $basketItem));
    }

    /**
     * Sepet status değişince kullanıcıya notify gider.
     *
     * @param Siparis   $order
     * @param SepetUrun $basketItem
     */
    public function orderStatusChangedNotification(Siparis $order)
    {
        $this->notify(new OrderStatusOnChangedMail($this, $order));
    }
}
