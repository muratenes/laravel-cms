<?php

namespace App\Repositories\Traits;

use App\Models\Config;

trait SepetSupportTrait
{
    /**
     * ürüne ait varyant var ise varyantlı fiyatı yoksa normal veya indirimli fiyatı döner.
     *
     * @param Product             $product
     * @param null|ProductVariant $productVariant
     *
     * @return float
     */
    public function getProductPriceByDiscountAndVariant(Product $product, ?ProductVariant $productVariant)
    {
        return $productVariant ? $productVariant->price : $product->current_last_price;
    }

    /**
     * ürünün varyanta göre stok durumunu gönderir.
     *
     * @param Product             $product
     * @param null|ProductVariant $productVariant
     *
     * @return int
     */
    public function getProductMaxQtyFromVariant(Product $product, ?ProductVariant $productVariant)
    {
        return $productVariant ? $productVariant->qty : $product->qty;
    }

    /**
     * @param Product    $product
     * @param null|int[] $subAttributeIdList sub attributeId list id
     * @param int        $qty
     *
     * @return array
     */
    public function addItemToBasket(Product $product, $subAttributeIdList = null, $qty = 1)
    {
        $variant = ProductVariant::urunHasVariant($product->id, $subAttributeIdList, currentCurrencyID());
        $productPrice = $this->getProductPriceByDiscountAndVariant($product, $variant);

        $attributeText = BasketItem::getAttributesText($subAttributeIdList);
        $attributeTextLang = BasketItem::getAttributesTextByLang(curLangId(), $subAttributeIdList);

        $maxQty = $this->getProductMaxQtyFromVariant($product, $variant);
        $maxQty -= $this->getAddedProductQtyFromCartItem($product->id, $subAttributeIdList);
        if ($maxQty < $qty) {
            return $this->response(false, __('lang.only_qty_left_of_this_product', ['qty' => $maxQty]));
        }

        $this->addItemToSessionCart($product, $productPrice, $subAttributeIdList, $attributeText, $qty, $attributeTextLang);
        $this->addProductToBasketItemOnDB($product, $productPrice, $attributeText, $qty, $attributeTextLang);

        return $this->response(true, __('lang.added_to_basket'));
    }

    /**
     * gönderilen ürünü session cart eklemeden önce mevcut mu bakar
     *  ürün sepette mevcut ise günceller yok ise ekler.
     *
     * @param Product     $product
     * @param float       $productPrice
     * @param null        $selectedSubAttributesIdList
     * @param null|string $attributeText               ürünün seçili attribute text
     * @param int         $qty
     * @param null|string $attributeTextLang           ürünün seçili attribute text dile göre
     *
     * @return
     */
    public function addItemToSessionCart(Product $product, $productPrice, $selectedSubAttributesIdList = null, $attributeText = '', $qty = 1, $attributeTextLang = '')
    {
        $isProductAdded = $this->checkAndUpdateProductAddedToCartWithAttribute($product, $productPrice, $selectedSubAttributesIdList, $qty);
        if ($isProductAdded) {
            return $this->cartItems();
        }
        $product->setAppends(['current_last_price', 'current_discount_price', 'last_cargo_price']);

        \Cart::add([
            'id'         => $this->getCartItemId($product->id, $selectedSubAttributesIdList),
            'name'       => $product->title_lang,
            'price'      => $productPrice,
            'quantity'   => $qty,
            'attributes' => [
                'sub_attribute_id_list' => $selectedSubAttributesIdList,
                'attributes_text'       => $attributeText,
                'attributes_text_lang'  => $attributeTextLang,
                'old_price'             => $product->current_discount_price ? $product->current_price : null,
                'cargo_price'           => $product->last_cargo_price,
                'product'               => $product->only(['id', 'title', 'title_lang', 'slug', 'current_last_price', 'current_discount_price', 'image']),
            ],
        ]);
    }

    /**
     * gönderilen ürünü db sepete ekler var ise günceller.
     *
     * @param Product     $product
     * @param float       $productPrice      ürün son fiyat
     * @param null        $attributeText
     * @param int         $qty
     * @param null|string $attributeTextLang
     *
     * @return false
     */
    public function addProductToBasketItemOnDB(Product $product, $productPrice, $attributeText = null, $qty = 1, $attributeTextLang = null)
    {
        $product->setAppends(['last_cargo_price', 'current_last_price']);
        if (! auth()->check()) {
            return false;
        }

        $currentBasket = Basket::getCurrentBasket();
        $item = $currentBasket->basket_items()->where(
            ['basket_id' => $currentBasket->id, 'product_id' => $product->id, 'attributes_text' => $attributeText]
        )->first();
        if ($item) {
            $item->update(['qty' => $item->qty + $qty, 'price' => $productPrice]);

            return $item;
        }

        return $currentBasket->basket_items()->create([
            'product_id'           => $product->id,
            'qty'                  => $qty,
            'price'                => $productPrice,
            'status'               => BasketItem::STATUS_ONAY_BEKLIYOR,
            'cargo_price'          => $product->last_cargo_price,
            'attributes_text'      => $attributeText,
            'attributes_text_lang' => $attributeTextLang,
        ]);
    }

    /**
     * eğer sepette aynı attribute 'da ürün varsa adet günceller.
     *
     * @param Product $product
     * @param float   $productPrice
     * @param null    $selectedSubAttributesIdList
     * @param int     $qty
     *
     * @return bool
     */
    public function checkAndUpdateProductAddedToCartWithAttribute(Product $product, $productPrice, $selectedSubAttributesIdList = null, $qty = 1)
    {
        foreach ($this->cartItems() as $item) {
            $cartItemId = $this->getCartItemId($product->id, $selectedSubAttributesIdList);
            if ($item->id === $cartItemId && $item->attributes->has('sub_attribute_id_list') && $item->attributes->sub_attribute_id_list) {
                if ($item->attributes->sub_attribute_id_list === $selectedSubAttributesIdList) {
                    $this->updateCartItem($cartItemId, [
                        'quantity'   => (int) $qty,
                        'price'      => $productPrice,
                        'attributes' => array_merge($item->attributes->toArray(), ['cargo_price' => $product->last_cargo_price]),
                    ]);

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * basket sessiondaki ürünleri veritabanı ile eşler.
     *
     * @param Basket $basket
     */
    private function matchSessionCartWithBasketItems(Basket $basket)
    {
        $basket->update(['currency_id' => Config::getCurrencyId()]);

        $cartItems = $this->cartItems();
        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->attributes->product['id'])->append('current_last_price');
            $this->updateCartItem($cartItem->id, [
                'price'      => $product->current_last_price,
                'attributes' => array_merge($cartItem->attributes->toArray(), ['cargo_price' => $product->last_cargo_price]),
            ]);
            if (false === $basket->isAddedToBasket($product, $cartItem->attributes->attributes_text)) {
                $basket->basket_items()->create([
                    'product_id'           => $product['id'],
                    'qty'                  => $cartItem->quantity,
                    'price'                => $product->current_last_price,
                    'attributes_text'      => $cartItem->attributes->attributes_text,
                    'attributes_text_lang' => $cartItem->attributes->attributes_text_lang,
                    'status'               => BasketItem::STATUS_ONAY_BEKLIYOR,
                    'cargo_price'          => $product->last_cargo_price,
                ]);
            } else {
                $basket->basket_items()->where(['product_id' => $product['id'], 'attributes_text' => $cartItem->attributes->attributes_text])
                    ->update([
                        'qty'         => $cartItem->quantity,
                        'price'       => $product->current_last_price,
                        'cargo_price' => $product->last_cargo_price,
                    ])
                ;
            }
        }
        $basket->basket_items()->whereNotIn('product_id', $this->getProductIdList())->delete();

        return $basket;
    }
}
