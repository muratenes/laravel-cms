<?php

namespace App\Mail;

use App\Models\Basket;
use App\Models\Config;
use App\Models\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusOnChangedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public User $user;
    public Order $order;
    public Basket $basket;
    public Config $site;
    public string $orderStatusText;

    public function __construct(User $user, Order $order)
    {
        $this->user = $user;
        $this->order = $order;
        $this->basket = $order->basket;
        $this->orderStatusText = Order::statusLabelStatic($this->order->status);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->site->title . '- ' . $this->orderStatusText)
            ->view('emails.orderStatusChangeMail')
        ;
    }
}
