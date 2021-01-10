<?php namespace App\Repositories\Interfaces;

interface SepetInterface extends BaseRepositoryInterface
{
    public function checkProductQtyCountCanAddToBasketItemCount($productId,$checkedQty, $subAttributesIdList = null);
}
