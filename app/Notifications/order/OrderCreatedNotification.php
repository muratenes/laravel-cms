<?php

namespace App\Notifications\order;

use App\Mail\Order\OrderCreateadMail;
use App\Models\Sepet;
use App\Models\Siparis;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

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
     * Get the notification's delivery channels.
     *
     * @param $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param User $user
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $user)
    {
        return new OrderCreateadMail($this->order);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
