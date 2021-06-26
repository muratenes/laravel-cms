<?php

namespace App\Mail\Order;

use App\Models\Sepet;
use App\Models\Siparis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreateadMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Siparis
     */
    public Siparis $order;

    /**
     * @var Sepet
     */
    public Sepet $basket;

    /**
     * Create a new notification instance.
     *
     * @param Siparis $order
     */
    public function __construct(Siparis $order)
    {
        $this->order = $order;
        $this->basket = $order->basket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.created')
            ->subject(__('lang.order_successfully_received'))
        ;
    }
}
