<?php

namespace App\Mail;

use App\Models\Ayar;
use App\Models\Sepet;
use App\Models\Siparis;
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
    public Siparis $order;
    public Sepet $basket;
    public Ayar $site;
    public string $orderStatusText;

    public function __construct(User $user, Siparis $order)
    {
        $this->user = $user;
        $this->order = $order;
        $this->basket = $order->basket;
        $this->site = Ayar::getCache();
        $this->orderStatusText = Siparis::statusLabelStatic($this->order->status);
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
