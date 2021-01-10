<?php namespace App\Repositories\Interfaces;

use App\Models\Sepet;

interface KuponInterface extends BaseRepositoryInterface
{
    /**
     * kupon tarih,aktiflik vs. kontrol eder eğer uygunsa sepete uygular
     * @param int[] $productIdList sepette bulunan ürünlerin id listesi
     * @param string $couponCode
     * @param float $cartSubTotalPrice sepetteki ürünlerin sub total değeri
     * @param int $currency para birimi
     * @param Sepet|null $basket
     * @return array
     */
    public function checkCoupon(array $productIdList, string $couponCode, float $cartSubTotalPrice, int $currency, ?Sepet $basket);

    public function decrementCouponQty($couponId = null);
}
