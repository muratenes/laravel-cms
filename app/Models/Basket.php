<?php

namespace App\Models;

use App\Library\Services\BasketService\Models\BasketItem;
use App\Models\Product\Product;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SepetSupportTrait;
use App\Utils\Concerns\Models\BasketAttributes;
use App\Utils\Concerns\Models\BasketRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Basket extends Model
{
    use BasketAttributes;
    use BasketRelations;
    use ResponseTrait;
    use SepetSupportTrait;
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * get existing user basket, otherwise create one.
     *
     * @return mixed
     */
    public static function getCurrentBasket(): self
    {
        $currentBasket = DB::table('baskets as s')
            ->leftJoin('orders as si', 'si.basket_id', '=', 's.id')
            ->where('s.user_id', auth()->id())
            ->whereRaw('si.id is null')
            ->orderByDesc('s.created_at')
            ->select('s.id')
            ->first()
        ;

        if ($currentBasket) {
            return self::find($currentBasket->id);
        }
        $currentBasket = self::create(['user_id' => auth()->id()]);
        session()->put('current_basket_id', $currentBasket->id);

        return $currentBasket;
    }

    public function basket_item_count(): int
    {
        return $this->hasMany(BasketItem::class)->where('basket_id', $this->id)->count();
    }

    /**
     * has the product been added to the cart ?
     */
    public function isAddedToBasket(Product $product, ?string $attributeText): bool
    {
        return $this->basket_items->search(function ($item) use ($product, $attributeText) {
            return $item->product_id === (int) $product->id && $item->attributes_text === $attributeText;
        });
    }
}
