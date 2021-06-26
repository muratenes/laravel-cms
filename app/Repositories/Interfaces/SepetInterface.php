<?php

namespace App\Repositories\Interfaces;

use App\Models\Siparis;

interface SepetInterface extends BaseRepositoryInterface
{
    public function checkProductQtyCountCanAddToBasketItemCount($productId, $checkedQty, $subAttributesIdList = null);

    /**
     * Sepetteki ürünleri iptal eder ve refunded_amountları günceller.
     *
     * @param Siparis $order
     *
     * @return mixed
     */
    public function cancelBasketItems(Siparis $order);
}
