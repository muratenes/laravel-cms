<?php

namespace App\Repositories\Traits;

use App\Models\Coupon;
use Cart;

trait CartTrait
{
    // ============ SESSION CART ==============

    /**
     * Session Sepetteki toplam ürün sayısı.
     *
     * @return mixed
     */
    public function getBasketItemCount()
    {
        return $this->cartItems()->count();
    }

    /**
     *  sepetteki ürünlerin id listesini getirir.
     *
     * @return array
     */
    public function getProductIdList()
    {
        return $this->cartItems()->map(function ($key) {
            return $key->attributes->product['id'];
        })->toArray();
    }

    /**
     * creates basket ID.
     *
     * @param int        $productID
     * @param null|array $selectedSubAttributesIdList
     *
     * @return mixed|string
     */
    public function getCartItemId(int $productID, ?array $selectedSubAttributesIdList)
    {
        return $selectedSubAttributesIdList ? $productID . '-' . implode('_', $selectedSubAttributesIdList) : $productID;
    }

    // ========== CRUD ACTIONS =================

    public function getCartItem($itemId)
    {
        return \Cart::get($itemId);
    }

    public function updateCartItem($id, array $data)
    {
        return \Cart::update($id, $data);
    }

    public function removeCartItem($id)
    {
        return \Cart::remove($id);
    }

    /**
     * get item qty by sub attributes.
     *
     * @param int        $productID          ürün id
     * @param null|array $subAttributeIdList seçilmiş sub attribute ıd
     *
     * @return int
     */
    public function getAddedProductQtyFromCartItem(int $productID, ?array $subAttributeIdList)
    {
        $cartItem = $this->getCartItem($this->getCartItemId($productID, $subAttributeIdList));

        return $cartItem ? $cartItem->quantity : 0;
    }

    // ================== STATIC METHODS =======================

    /**
     * Session Sepetteki toplam ürün sayısı.
     *
     * @return mixed
     */
    public static function getCartTotalCargoAmount()
    {
        return self::cartItems()->sum(function ($item) {
            return $item->attributes['cargo_price'] * $item->quantity;
        });
    }

    /**
     * sepetteki ürünler.
     *
     * @return mixed
     */
    public static function cartItems()
    {
        return \Cart::getContent();
    }

    /**
     * sepete eklenen ürünün adet bilgisini getirir.
     *
     * @param $cartItem
     *
     * @return mixed
     */
    public function getCartItemQuantity($cartItem)
    {
        return $cartItem->quantity;
    }

    /**
     * @param object $cartItem basket item
     */
    public function decrementItem($cartItem)
    {
        $quantity = $this->getCartItemQuantity($cartItem);
        if (1 === $quantity) {
            $this->removeCartItem($cartItem->id);
        } else {
            $this->updateCartItem($cartItem->id, [
                'quantity' => [
                    'relative' => false,
                    'value'    => $quantity - 1,
                ],
            ]);
        }
    }

    /**
     * basket sub total.
     *
     * @return mixed
     */
    public static function getCardSubTotal()
    {
        return \Cart::getSubTotal();
    }

    /**
     * basket total.
     *
     * @return mixed
     */
    public static function getCartTotal()
    {
        return self::cartItems()->sum(function ($item) {
            return self::getCartItemTotalByItem($item);
        })
            - Coupon::getCouponDiscountPrice();
    }

    public static function getCartItemTotalByItem($cartItem)
    {
        return ($cartItem->price + $cartItem->attributes['cargo_price']) * $cartItem->quantity;
    }
}
