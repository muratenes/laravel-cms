<?php

namespace App\Http\Controllers;


use App\Jobs\NewOrderAddedJob;
use App\Mail\Order\OrderCreateadMail;
use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Siparis;
use App\Notifications\order\AdminNewOrderNotification;
use App\Notifications\order\OrderCancelledNotification;
use App\Notifications\order\OrderCreatedNotification;
use App\Notifications\order\OrderItemStatusChangedNotification;
use App\User;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $basket = Sepet::getCurrentBasket();
        $order = Siparis::with(['basket.basket_items.product', 'basket.user'])->first();
        $user = $request->user();
        $basketItem = $order->basket->basket_items->first();
        // initial

        $user->notify(new OrderItemStatusChangedNotification($order,$order->basket->basket_items->first() ));

        //
//        Mail::to($request->user())->send(new OrderCreateadMail($order));
//        return new \App\Mail\Order\OrderCreateadMail($order);
        dd('a');
        $order->notify(new NewOrder($order));
        dd('sn');
    }

}
