<?php

namespace App\Notifications\order;

use App\Models\Product\Urun;
use App\Models\SepetUrun;
use App\Models\Siparis;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderItemStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Siparis
     */
    public Siparis $order;

    /**
     * @var SepetUrun
     */
    public SepetUrun  $basketItem;

    /**
     * @var Urun
     */
    public Urun $product;

    /**
     * Create a new notification instance.
     *
     * @param Siparis   $order
     * @param SepetUrun $basketItem
     */
    public function __construct(Siparis $order, SepetUrun $basketItem)
    {
        $this->order = $order;
        $this->basketItem = $basketItem;
        $this->product = $basketItem->product;
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
        $productUrl = route('product.detail', $this->product->slug);
        $statusLabel = SepetUrun::statusLabelStatic($this->basketItem->status);

        return (new MailMessage())
            ->subject(__('lang.order_item_status_changed', ['product' => $this->product->title, 'status' => SepetUrun::statusLabelStatic($this->basketItem->status)]))

            ->line(__('lang.hello_username', ['username' => $user->full_name]))
            ->line(__('lang.order_item_status_changed', ['product' => $this->product->title, 'status' => SepetUrun::statusLabelStatic($this->basketItem->status)]))
            ->line(new HtmlString('<b>' . __('lang.order_code') . "</b> : {$this->order->code}"))
            ->line(new HtmlString('<b>' . __('lang.status') . "</b> : {$statusLabel}"))
            ->line(new HtmlString('<b>' . __('lang.product') . "</b> : <a href={$productUrl}>{$this->product->title}</a>"))
            ->line(new HtmlString('<b>' . __('lang.price') . "</b> : {$this->basketItem->price} {$this->order->currency_symbol}"))
            ->line(new HtmlString('<b>' . __('lang.qty') . "</b> : {$this->basketItem->qty}"))
            ->line(new HtmlString('<b>' . __('lang.cargo_price') . "</b> : {$this->basketItem->cargo_total} {$this->order->currency_symbol}"))
            ->line(new HtmlString('<b>' . __('lang.product_total') . "</b> : {$this->basketItem->total} {$this->order->currency_symbol}"))

            ->action(__('lang.show_order'), url(route('user.orders.detail', $this->order->id)))
        ;
    }
}
