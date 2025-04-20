<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Repositories\Interfaces\ProductAttributeInterface;

class ElProductAttributeDal extends BaseRepository implements ProductAttributeInterface
{
    public function __construct(ProductAttribute $model)
    {
        parent::__construct($model);
    }

    public function getAllAttributes()
    {
        return $this->model->all(['active' => 1])->get();
    }

    public function getAllSubAttributes()
    {
        return ProductSubAttribute::whereHas('attribute', function ($query) {
            $query->where('active', 1);
        })->get();
    }
}
