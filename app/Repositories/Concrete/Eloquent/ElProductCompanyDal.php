<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Product\ProductCompany;
use App\Repositories\Interfaces\ProductCompanyInterface;

class ElProductCompanyDal extends BaseRepository implements ProductCompanyInterface
{
    public function __construct(ProductCompany $model)
    {
        parent::__construct($model);
    }
}
