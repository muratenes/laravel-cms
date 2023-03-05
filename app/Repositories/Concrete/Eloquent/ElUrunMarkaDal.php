<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Product\ProductBrand;
use App\Repositories\Interfaces\UrunMarkaInterface;

class ElUrunMarkaDal extends BaseRepository implements UrunMarkaInterface
{
    protected $model;

    public function __construct(ProductBrand $model)
    {
        parent::__construct($model);
    }
}
