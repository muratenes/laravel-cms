<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service)
    {
        $auth_user = Socialite::driver($service)->user();
        $user = User::updateOrCreate(
            [
                'email' => $auth_user->email,
            ],
            [
                'token'     => $auth_user->token,
                'name'      => $auth_user->name,
                'surname'   => '',
                'is_active' => 1,
            ]
        );

        Auth::login($user, true);
        request()->session()->regenerate();
        $current_basket_id = Basket::getCurrentBasket();
        session()->put('current_basket_id', $current_basket_id);
        if (Cart::count() > 0) {
            foreach (Cart::content() as $cartItem) {
                if ($cartItem->options->selectedSubAttributesIdList) {
                    $variant = ProductVariant::urunHasVariant($cartItem->id, $cartItem->options->selectedSubAttributesIdList);
                    if (false !== $variant) {
                        $cartItem->price = $variant->price;
                    }
                }
                BasketItem::updateOrCreate(
                    ['basket_id' => $current_basket_id, 'product_id' => $cartItem->id, 'attributes_text' => $cartItem->options->attributeText],
                    ['qty'       => $cartItem->qty, 'price' => $cartItem->price,
                        'status' => BasketItem::STATUS_ONAY_BEKLIYOR, 'attributes_text' => $cartItem->options->attributeText, ]
                );
            }
        }

        Cart::destroy();
        $basket_itemss = BasketItem::where('basket_id', $current_basket_id)->get();
        foreach ($basket_itemss as $basketItem) {
            Cart::add($basketItem->product->id, $basketItem->product->title, $basketItem->qty, $basketItem->price, ['slug' => $basketItem->product->slug, 'attributeText' => $basketItem->attributes_text, 'image' => $basketItem->product->image]);
        }

        return redirect()->intended('/')->with('message', 'Hoşgeldin Giriş Başarılı');
    }

    public function handleProviderGoogleCallback()
    {
    }
}
