<?php

namespace App\Models\Product;

use App\Utils\Concerns\Filterable;
use App\Utils\Concerns\Models\MultiLanguageRelations;
use App\Utils\Concerns\ProductLanguage;
use App\Utils\Concerns\ProductPrice;
use App\Utils\Concerns\ProductRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Filterable;
    use MultiLanguageRelations;
    use ProductLanguage;
    use ProductPrice;
    use ProductRelations;
    use SoftDeletes;

    public const MODULE_NAME = 'product';
    public const PER_PAGE = 12;
    public const LANG_FIELDS = ['title', 'spot', 'tags', 'properties', 'desc', 'cargo_price'];

    public $perPage = 12;

    protected $guarded = ['id'];

    protected $casts = [
        'tags'       => 'array',
        'properties' => 'array',
    ];
}
