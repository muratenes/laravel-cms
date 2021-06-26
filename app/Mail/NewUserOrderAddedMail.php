<?php

namespace App\Mail;

use App\Models\Ayar;
use App\Models\Sepet;
use App\Models\Siparis;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserOrderAddedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;
    public Sepet $basket;
    public Siparis $order;
    public Ayar $site;

    /**
     * Create a new job instance.
     *
     * @param Sepet   $basket
     * @param User    $user
     * @param Siparis $order
     */
    public function __construct(Sepet $basket, User $user, Siparis $order)
    {
        $this->basket = $basket;
        $this->user = $user;
        $this->order = $order;
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
            ->subject($this->site->title . ' - Sipariş Bilgileri')
            ->view('emails.newUserOrder')
        ;
    }
}
