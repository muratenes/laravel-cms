<?php

namespace App\Mail;

use App\Models\Ayar;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $order, $basketItems, $site;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $order, $basketItems)
    {
        $this->user = $user;
        $this->order = $order;
        $this->basketItems = $basketItems;
        $this->site = Ayar::getCache();
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
            ->view('emails.newOrderAdminNotification');
    }
}
