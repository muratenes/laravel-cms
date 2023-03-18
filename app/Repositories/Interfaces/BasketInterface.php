<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface BasketInterface
{
    public function checkProductQtyCountCanAddToBasketItemCount(int $productId, int $checkedQty, $subAttributesIdList = null);

    /**
     * Sepetteki ürünleri iptal eder ve refunded_amountları günceller.
     *
     * @param Order $order
     *
     * @return mixed
     */
    public function cancelBasketItems(Order $order);
}
