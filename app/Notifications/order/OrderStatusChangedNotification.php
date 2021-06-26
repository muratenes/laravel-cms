<?php

namespace App\Notifications\order;

use App\Models\Siparis;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Siparis
     */
    public Siparis $order;

    /**
     * @var User
     */
    public User $user;

    /**
     * Create a new notification instance.
     *
     * @param Siparis $order
     */
    public function __construct(Siparis $order)
    {
        $this->order = $order;
        $this->user = $order->basket->user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
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
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $statusLabel = Siparis::statusLabelStatic($this->order->status);

        return (new MailMessage())
            ->subject(__('lang.order_status_changed', ['status' => $statusLabel]))
            ->line(__('lang.hello_username', ['username' => $this->user->full_name]))
            ->line(__('lang.order_status_changed', ['status' => $statusLabel]))
            ->line(__('lang.order_code') . ": {$this->order->order_code}")
            ->line(__('lang.sub_total') . ": {$this->order->order_price} {$this->order->currency_symbol}")
            ->line(__('lang.cargo_price') . " : {$this->order->cargo_price} {$this->order->currency_symbol}")
            ->line(__('lang.coupon_total') . ": {$this->order->coupon_price} {$this->order->currency_symbol}")
            ->line(new HtmlString('<strong>' . __('lang.total_amount') . "</strong> : {$this->order->order_total_price} {$this->order->currency_symbol}"))
            ->action(__('lang.show_order'), url(route('user.orders.detail', $this->order->id)))
        ;
    }
}
