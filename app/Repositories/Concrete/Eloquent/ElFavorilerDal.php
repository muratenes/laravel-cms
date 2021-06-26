<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Favori;
use App\Repositories\Interfaces\FavorilerInterface;

class ElFavorilerDal extends BaseRepository implements FavorilerInterface
{
    protected $model;

    public function __construct(Favori $model)
    {
        parent::__construct($model);
    }
}
