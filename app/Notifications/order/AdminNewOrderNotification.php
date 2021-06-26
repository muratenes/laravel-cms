<?php

namespace App\Notifications\order;

use App\Models\Siparis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AdminNewOrderNotification extends Notification implements ShouldQueue
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
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Yeni sipariş alındı')
            ->line("{$this->order->order_total_price} {$this->order->currency_symbol} tutarında Yeni sipariş var")
            ->line(new HtmlString('<strong>Sipariş Bilgileri</strong>'))
            ->line("Sipariş Kodu : {$this->order->code}")
            ->line("Sipariş Tarihi : {$this->order->created_at}")
            ->line(new HtmlString('<strong>Fiyat Bilgileri</strong>'))
            ->line("Alt Toplam : {$this->order->order_price} {$this->order->currency_symbol}")
            ->line("Kargo Toplam : {$this->order->cargo_price} {$this->order->currency_symbol}")
            ->line("Kupon Toplam : {$this->order->coupon_price} {$this->order->currency_symbol}")
            ->line(new HtmlString("<strong>Toplam Tutar</strong> : {$this->order->order_total_price} {$this->order->currency_symbol}"))
            ->line(new HtmlString('<strong>Müşteri Bilgileri</strong>'))
            ->line("Ad Soyad : {$this->order->full_name}")
            ->line("Telefon : {$this->order->phone}")
            ->line(new HtmlString('<strong>Adres Bilgileri</strong>'))
            ->line("Teslimat Adresi : {$this->order->adres}")
            ->line("Fatura Adresi : {$this->order->fatura_adres}")

            ->action('Siparişi Gör', url(route('admin.order.edit', $this->order->id)))
        ;
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
