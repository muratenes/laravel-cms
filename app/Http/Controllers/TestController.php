<?php

namespace App\Http\Controllers;


use App\Jobs\NewOrderAddedJob;
use App\Mail\Order\OrderCreateadMail;
use App\Models\Builder\Menu;
use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Siparis;
use App\Notifications\order\AdminNewOrderNotification;
use App\Notifications\order\OrderCancelledNotification;
use App\Notifications\order\OrderCreatedNotification;
use App\Notifications\order\OrderItemStatusChangedNotification;
use App\Repositories\Interfaces\AccountInterface;
use App\User;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    /**
     * @var AccountInterface
     */
    private AccountInterface $accountService;

    public function __construct(AccountInterface $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index(Request $request)
    {
//        $basket = Sepet::getCurrentBasket();
        $order = Siparis::with(['basket.basket_items.product', 'basket.user'])->first();
        $user = $request->user();
        $basketItem = $order->basket->basket_items->first();
        // initial

        $a = $this->accountService->find(1);
        dd($a);
        dd('a');
        $order->notify(new NewOrder($order));
        dd('sn');
    }

}
