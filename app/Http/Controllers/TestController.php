<?php

namespace App\Http\Controllers;

use App\Library\Services\BasketService\BasketService;
use App\Library\Services\BasketService\Models\BasketItem;
use App\LibraryTest\Solid\OpenClosed\Login\LoginService;
use App\LibraryTest\Solid\OpenClosed\Login\Models\User;
use App\LibraryTest\Solid\OpenClosed\Login\Providers\UserAuthentication;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $loginService = new LoginService();
        $user = new User('admin@admin.com', 'adminadmin');
        $user->setGuard('admin');
        $user = $loginService->login(new UserAuthentication(), $user);
        dd(
            $loginService->logout(new UserAuthentication()),
            \Auth::user()
        );

        // //        $basket = BasketService::make('file');
//        $basket = BasketService::make('database');
        // //        dd($basket);
        // //        $basket = new BasketService();
//        $basketItem = new BasketItem("Ürün başlığı",1200);
//        $basketItem2 = new BasketItem("Kırmızı Jaguar",5000);
//        $basket->addToBasket($basketItem);
//        $basket->addToBasket($basketItem2);
//        $basket->clearBasket();
//        dd(
//            $basket->getBasketItems(),
//            $basket = $basket->getBasket(),
//            $basket->id
//        );
//
//        $basket = new BasketService('database');
        // //        dd($service);
//        $basketItem = new BasketItem("Ürün başlığı",1200);
//        $basket->addToBasket($basketItem);
//        dd(
//            $basket->getBasket("123")
//        );
    }
}
