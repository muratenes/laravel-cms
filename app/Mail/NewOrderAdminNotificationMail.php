<?php

namespace App\Mail;

use App\Models\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderAdminNotificationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;
    public $order;
    public $basketItems;

    /**
     * Create a new message instance.
     *
     * @param mixed $user
     * @param mixed $order
     * @param mixed $basketItems
     */
    public function __construct($user, $order, $basketItems)
    {
        $this->user = $user;
        $this->order = $order;
        $this->basketItems = $basketItems;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name') . ' - Yeni Sipariş')
            ->view('emails.newOrderAdminNotification')
        ;
    }
}
