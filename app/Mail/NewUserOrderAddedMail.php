<?php

namespace App\Mail;

use App\Models\Basket;
use App\Models\Config;
use App\Models\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserOrderAddedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;
    public Basket $basket;
    public Order $order;

    /**
     * Create a new job instance.
     *
     * @param Basket $basket
     * @param User   $user
     * @param Order  $order
     */
    public function __construct(Basket $basket, User $user, Order $order)
    {
        $this->basket = $basket;
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->site->title . ' - Sipariş Bilgileri')
            ->view('emails.newUserOrder')
        ;
    }
}
