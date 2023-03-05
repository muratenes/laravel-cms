<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Favorite;
use App\Repositories\Interfaces\FavorilerInterface;

class ElFavorilerDal extends BaseRepository implements FavorilerInterface
{
    protected $model;

    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }
}
