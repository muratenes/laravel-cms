<?php

namespace App\Repositories\Interfaces;

use App\Models\Sepet;

interface KuponInterface
{
    /**
     * kupon tarih,aktiflik vs. kontrol eder eğer uygunsa sepete uygular.
     *
     * @param int[]      $productIdList     sepette bulunan ürünlerin id listesi
     * @param string     $couponCode
     * @param float      $cartSubTotalPrice sepetteki ürünlerin sub total değeri
     * @param int        $currency          para birimi
     * @param null|Sepet $basket
     *
     * @return array
     */
    public function checkCoupon(array $productIdList, string $couponCode, float $cartSubTotalPrice, int $currency, ?Sepet $basket);

    /**
     * kupon adet düşürür.
     *
     * @param null|int $couponId kupon id
     *
     * @return bool
     */
    public function decrementCouponQty($couponId = null);
}
