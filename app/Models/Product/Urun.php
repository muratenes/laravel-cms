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
    use SoftDeletes;
    use ProductRelations;
    use ProductLanguage;
    use ProductPrice;
    use Filterable;

    const IMAGE_QUALITY = 80;
    const IMAGE_RESIZE = null;
    const MODULE_NAME = 'product';


    protected $table = "urunler";
    protected $guarded = ['id'];

    protected $casts = [
        'tags' => 'array',
        'properties' => 'array',
    ];

    public $perPage = 12;
    const PER_PAGE = 12;

}
