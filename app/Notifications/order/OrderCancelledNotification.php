<?php

namespace App\Notifications\order;

use App\Models\Siparis;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Siparis
     */
    public Siparis $order;

    /**
     * Create a new notification instance.
     *
     * @param Siparis $order
     */
    public function __construct(Siparis $order)
    {
        $this->order = $order;
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
     * @param User $user
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $user)
    {
        return (new MailMessage())
            ->subject(__('lang.refund_information'))
            ->line(__('lang.hello_username', ['username' => $user->full_name]) . ',' . __('lang.your_refund_has_been_processed_successfully'))
            ->line(new HtmlString('<b>' . __('lang.order_code') . "</b> : {$this->order->code}"))
            ->line(__('lang.your_refund_has_been_processed_successfully'))
            ->line(new HtmlString('<br/>'))
            ->line(__('lang.order_refund_text', ['code' => "{$this->order->code}", 'price' => $this->order->order_total_price, 'date' => $this->order->created_at]))
            ->line(__('lang.order_refund_bank_text', ['day' => 8]))
            ->action(__('lang.show_order'), url(route('user.orders', $this->order->id)))
        ;
    }
}
