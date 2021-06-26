<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\Siparis;
use App\Repositories\Interfaces\AccountInterface;
use Illuminate\Http\Request;

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
