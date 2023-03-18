<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\EBulten;
use App\Repositories\Interfaces\EBultenInterface;

class ElEBultenDal extends BaseRepository implements EBultenInterface
{
    public function __construct(EBulten $model)
    {
        parent::__construct($model);
    }
}
