<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Product\ProductBrand;
use App\Repositories\Interfaces\ProductBrandInterface;

class ElProductBrandDal extends BaseRepository implements ProductBrandInterface
{
    protected $model;

    public function __construct(ProductBrand $model)
    {
        parent::__construct($model);
    }
}
