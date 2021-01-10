<?php

namespace App\Models;

use App\Models\Product\Urun;
use App\User;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SepetSupportTrait;
use App\Utils\Concerns\Models\BasketAttributes;
use App\Utils\Concerns\Models\BasketRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Sepet extends Model
{
    use SoftDeletes;
    use SepetSupportTrait;
    use ResponseTrait;
    use BasketRelations;
    use BasketAttributes;

    protected $table = 'sepet';
    protected $guarded = ['id'];


    /**
     * kullanıcının şimdiki sepetini getirir yok ise oluşturur
     * @return mixed
     */
    public static function getCurrentBasket()
    {
        $current_basket = DB::table('sepet as s')
            ->leftJoin('siparisler as si', 'si.sepet_id', '=', 's.id')
            ->where('s.user_id', auth()->id())
            ->whereRaw('si.id is null')
            ->orderByDesc('s.created_at')
            ->select('s.id')
            ->first();
        if ($current_basket) return Sepet::find($current_basket->id);
        $current_basket = Sepet::create(['user_id' => auth()->id()]);
        session()->put('current_basket_id', $current_basket->id);

        return $current_basket;
    }

    /**
     * sepetteki ürün sayısı
     * @return int
     */
    public function basket_item_count()
    {
        return $this->hasMany('App\Models\SepetUrun')->where('sepet_id', $this->id)->count();
    }

    /**
     * ürün sepete(DB) daha önce eklenmiş mi ?
     * @param Urun $product
     * @param string|null $attributeText sepet attributes_text
     */
    public function isAddedToBasket(Urun $product, ?string $attributeText)
    {
        return $this->basket_items->search(function ($item) use ($product, $attributeText) {
            return $item->product_id == (int)$product->id and $item->attributes_text == $attributeText;
        });
    }


}
