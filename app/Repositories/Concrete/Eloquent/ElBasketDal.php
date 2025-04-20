<?php

namespace App\Repositories\Concrete\Eloquent;


use App\Repositories\Interfaces\BasketInterface;

class ElBasketDal extends BaseRepository implements BasketInterface
{
    public function __construct(Basket $model)
    {
        parent::__construct($model);
    }

    /**
     *  Parametre olarak gönderilen $checkedQty $subAttributesIdList göre Ürün varyantlarında stok durumu kontrol edilir
     * sonra kullanıcının sepetinde bu üründen kaç adet var ve stokda kaç tane var kontrol edilir
     * eğer $checkedQty $maxQty den büyükse   $checkedQty = $maxQty  değeri atanır ve max o adet kadar ekleyebilir veya silebilir
     * kullanıcı sepete eklediği ürün sayısınndan az bir sayı gönderdiyse eksi olarak geri döner örn 4 ürün varken 3 gönderirse -1 döner.
     *
     * @param null|mixed $subAttributesIdList
     *
     * @return $checkedQty
     */
    public function checkProductQtyCountCanAddToBasketItemCount(int $productId, int $qty, $subAttributesIdList = null)
    {
        // TODO : refactor
        $variant = ProductVariant::urunHasVariant($productId, $subAttributesIdList);
        $product = Product::findOrFail($productId);
        $maxQty = $product->qty;

        if (false !== $variant) {
            $maxQty = $variant->qty;
        }

        $search = Cart::search(function ($key, $value) use ($product, $subAttributesIdList) {
            return $key->id === $product->id && $key->options->selectedSubAttributesIdList === $subAttributesIdList;
        })->first();

        null !== $search ?: null;
        if (null !== $search) {
            $maxQty = $maxQty - $search->qty;
            0 !== $qty ? $qty -= $search->qty : null;
        }
        if ($qty > $maxQty) {
            $qty = $maxQty;
        }

        return $qty;
    }

    public function cancelBasketItems(Order $order)
    {
        $basketItems = BasketItem::withTrashed()->where('basket_id', $order->basket_id)->get();
        foreach ($basketItems as $basketItem) {
            $basketItem->update(['status' => BasketItem::STATUS_IPTAL_EDILDI, 'refunded_amount' => $basketItem->total]);
        }
    }
}
