<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Product\UrunMarka;
use App\Repositories\Interfaces\UrunMarkaInterface;

class ElUrunMarkaDal extends BaseRepository implements UrunMarkaInterface
{
    protected $model;

    public function __construct(UrunMarka $model)
    {
        parent::__construct($model);
    }
}
