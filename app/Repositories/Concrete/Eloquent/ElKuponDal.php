<?php namespace App\Repositories\Concrete\Eloquent;

use App\Jobs\DeleteAllLogsJobs;
use App\Models\Banner;
use App\Models\Coupon;
use App\Models\KategoriUrun;
use App\Models\Log;
use App\Models\Sepet;
use App\Models\Product\Urun;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\BannerInterface;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Interfaces\LogInterface;
use App\Repositories\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;
use phpDocumentor\Reflection\Types\Boolean;

class ElKuponDal implements KuponInterface
{
    use ResponseTrait;

    protected $model;

    public function __construct(Coupon $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = array("*"), $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = array("*"), $perPageItem = null, $relations = null)
    {
        return $this->model->allWithPagination($filter, $columns, $perPageItem);
    }

    public function getById($id, $columns = array('*'), $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = array('*'), $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

    /**
     * @param int[] $productIdList sepette bulunan ürünlerin id listesi
     * @param string $couponCode
     * @param float $cartSubTotalPrice sepetteki ürünlerin sub total değeri
     * @param int $currency para birimi
     * @param Sepet|null $basket
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

        if (!$coupon) {
            $this->forgetCoupon($basket);
            return $this->response(false, "kupon bulunamadı veya süresi tükendi");
        }
        $categoryIDList = [];

        $productCategories = Urun::select('parent_category_id', 'sub_category_id')->whereIn('id', $productIdList)->get();
        foreach ($productCategories as $product){
            $categoryIDList[] = $product->parent_category_id;
            $categoryIDList[] = $product->sub_category_id;
        }

        $couponCategoryIdList = [];
        foreach ($coupon->categories as $couponCategory){
            $couponCategoryIdList[] = $couponCategory->id;
            if (!$couponCategory->parent_category_id) {
                array_push($couponCategoryIdList,...$couponCategory->sub_categories->pluck('id')->toArray());
            }
        }

        $couponCategoryTitleList = implode(',', $coupon->categories->pluck('title')->toArray());
        $hasDifferentCategories = collect($categoryIDList)->diff($couponCategoryIdList)->all();

        if ($coupon->qty <= 0) {
            $response = $this->response(false, "Üzgünüz bu kuponu tükendi");
        } else if ($cartSubTotalPrice < $coupon->min_basket_price) {
            $response = $this->response(false, "Bu kuponu uygulamak için sepetinizde minimum $coupon->min_basket_price TL değerinde ürün olmalıdır");
        } else if (count($hasDifferentCategories) > 0) {
            $response = $this->response(false, "Bu kupon sadece {$couponCategoryTitleList} kategorilerinde geçerlidir.kuponu kullanmak için diğer kategorilerdeki ürünleri sepetten çıkarmalısınız");
        } else {
            if ($basket) {
                $basket->update(['coupon_id' => $coupon->id]);
            }
            session()->put('coupon', $coupon->only('id', 'code', 'discount_price'));
            $response = $this->response(true, "Kupon uygulandı");
        }
        if (!$response['status']) {
            $this->forgetCoupon($basket);
        }
        return $response;
    }

    /**
     * @param null|int $couponId kupon id
     * @return Boolean
     */
    public function decrementCouponQty($couponId = null)
    {
        if (!$couponId) return false;
        $coupon = Coupon::find($couponId);
        if (!$coupon) return false;
        $coupon->decrement('qty', 1);
        return true;
    }

    /**
     * kuponu sessiondan ve veritabanından siler
     * @param Sepet|null $basket
     */
    private function forgetCoupon(?Sepet $basket)
    {
        session()->forget('coupon');
        if ($basket) {
            $basket->update(['coupon_id' => null]);
        }
    }
}
