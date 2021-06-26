<?php

// ============= SESSION CART HELPERS ===============

use App\Repositories\Traits\CartTrait;

/**
 * Cart kargo toplam fiyat.
 *
 * @return mixed
 */
function cartTotalCargoPrice()
{
    return CartTrait::getCartTotalCargoAmount();
}

/**
 * sepet total miktar.
 *
 * @return mixed
 */
function cartTotalPrice()
{
    return CartTrait::getCartTotal();
}

/**
 * sepet total miktar.
 *
 * @return mixed
 */
function cartSubTotal()
{
    return CartTrait::getCardSubTotal();
}

/**
 * sepetteki tüm ürünleri getirir.
 *
 * @return mixed
 */
function cartItems()
{
    return CartTrait::cartItems();
}

/**
 * sepetteki tüm ürünleri sayısı.
 *
 * @return mixed
 */
function cartItemCount()
{
    return count(CartTrait::cartItems());
}

/**
 * gönderilen sepet ürünün toplam hesaplanmış tutarı gelir.
 *
 * @param $cartItem
 *
 * @return float|int
 */
function getCartItemTotalByItem($cartItem)
{
    return CartTrait::getCartItemTotalByItem($cartItem);
}
