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
        $order = Siparis::where('id',11)->first();
        $orderIyzico = $order->iyzico;
        $user = User::first();
        $basketItem = SepetUrun::first();
//        dd($request->user()->email);
//        Mail::to($request->user())->send(new OrderCreateadMail($order));
//        $request->user()->notify(new AdminNewOrderNotification($order));
//        $this->dispatch(new NewOrderAddedJob($order));
//        $user->notify(new OrderItemStatusChangedNotification($order, $basketItem));
//        $order->notify(new OrderCancelledNotification($order));

        dump($orderIyzico->iyzicoJson && $orderIyzico['status'] == 'success');
       foreach($orderIyzico->iyzicoJson['itemTransactions'] as $item){
           dump($item);
           SepetUrun::where('id',$item['itemId'])->update(['payment_transaction_id' => $item['paymentTransactionId']]);
       }

        dd($basket->total);
    }

}
