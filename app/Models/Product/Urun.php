<?php

namespace App\Models\Product;

use App\Utils\Concerns\Filterable;
use App\Utils\Concerns\ProductLanguage;
use App\Utils\Concerns\ProductPrice;
use App\Utils\Concerns\ProductRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use Filterable;
    use ProductLanguage;
    use ProductPrice;
    use ProductRelations;
    use SoftDeletes;

    public const IMAGE_QUALITY = 80;
    public const IMAGE_RESIZE = null;
    public const MODULE_NAME = 'product';
    public const PER_PAGE = 12;

    public $perPage = 12;

    protected $table = 'urunler';
    protected $guarded = ['id'];

    protected $casts = [
        'tags'       => 'array',
        'properties' => 'array',
    ];
}
