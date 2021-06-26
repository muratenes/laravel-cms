<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Coupon;
use App\Models\Product\Urun;
use App\Models\Sepet;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Traits\ResponseTrait;
use Carbon\Carbon;

class ElKuponDal extends BaseRepository implements KuponInterface
{
    use ResponseTrait;

    protected $model;

    public function __construct(Coupon $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int[]      $productIdList     sepette bulunan ürünlerin id listesi
     * @param string     $couponCode
     * @param float      $cartSubTotalPrice sepetteki ürünlerin sub total değeri
     * @param int        $currency          para birimi
     * @param null|Sepet $basket
     *
     * @return array
     */
    public function checkCoupon(array $productIdList, string $couponCode, float $cartSubTotalPrice, int $currency, ?Sepet $basket)
    {
        $currentDate = Carbon::now();
        $coupon = Coupon::with('categories.sub_categories')->where([
            ['active', '=', 1],
            ['code', '=', $couponCode],
            ['currency_id', '=', $currency],
            ['start_date', '<=', $currentDate],
            ['end_date', '>=', $currentDate],
        ])->first();

        if (! $coupon) {
            $this->forgetCoupon($basket);

            return $this->response(false, 'kupon bulunamadı veya süresi tükendi');
        }
        $categoryIDList = [];

        $productCategories = Urun::select('parent_category_id', 'sub_category_id')->whereIn('id', $productIdList)->get();
        foreach ($productCategories as $product) {
            $categoryIDList[] = $product->parent_category_id;
            $categoryIDList[] = $product->sub_category_id;
        }

        $couponCategoryIdList = [];
        foreach ($coupon->categories as $couponCategory) {
            $couponCategoryIdList[] = $couponCategory->id;
            if (! $couponCategory->parent_category_id) {
                array_push($couponCategoryIdList, ...$couponCategory->sub_categories->pluck('id')->toArray());
            }
        }

        $couponCategoryTitleList = implode(',', $coupon->categories->pluck('title')->toArray());
        $hasDifferentCategories = collect($categoryIDList)->diff($couponCategoryIdList)->all();

        if ($coupon->qty <= 0) {
            $response = $this->response(false, 'Üzgünüz bu kuponu tükendi');
        } elseif ($cartSubTotalPrice < $coupon->min_basket_price) {
            $response = $this->response(false, "Bu kuponu uygulamak için sepetinizde minimum {$coupon->min_basket_price} TL değerinde ürün olmalıdır");
        } elseif (\count($hasDifferentCategories) > 0) {
            $response = $this->response(false, "Bu kupon sadece {$couponCategoryTitleList} kategorilerinde geçerlidir.kuponu kullanmak için diğer kategorilerdeki ürünleri sepetten çıkarmalısınız");
        } else {
            if ($basket) {
                $basket->update(['coupon_id' => $coupon->id]);
            }
            session()->put('coupon', $coupon->only('id', 'code', 'discount_price'));
            $response = $this->response(true, 'Kupon uygulandı');
        }
        if (! $response['status']) {
            $this->forgetCoupon($basket);
        }

        return $response;
    }

    /**
     * @param null|int $couponId kupon id
     *
     * @return bool
     */
    public function decrementCouponQty($couponId = null)
    {
        if (! $couponId) {
            return false;
        }
        $coupon = Coupon::find($couponId);
        if (! $coupon) {
            return false;
        }
        $coupon->decrement('qty', 1);

        return true;
    }

    /**
     * kuponu sessiondan ve veritabanından siler.
     *
     * @param null|Sepet $basket
     */
    private function forgetCoupon(?Sepet $basket)
    {
        session()->forget('coupon');
        if ($basket) {
            $basket->update(['coupon_id' => null]);
        }
    }
}
