<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\FAQ;
use App\Repositories\Interfaces\SSSInterface;

class ElFAQDal extends BaseRepository implements SSSInterface
{
    public function __construct(FAQ $model)
    {
        parent::__construct($model);
    }
}
