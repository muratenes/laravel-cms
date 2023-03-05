<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface SepetInterface extends BaseRepositoryInterface
{
    public function checkProductQtyCountCanAddToBasketItemCount($productId, $checkedQty, $subAttributesIdList = null);

    /**
     * Sepetteki ürünleri iptal eder ve refunded_amountları günceller.
     *
     * @param Order $order
     *
     * @return mixed
     */
    public function cancelBasketItems(Order $order);
}
