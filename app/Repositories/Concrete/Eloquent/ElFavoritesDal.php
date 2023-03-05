<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Favorite;
use App\Repositories\Interfaces\FavoritesInterface;

class ElFavoritesDal extends BaseRepository implements FavoritesInterface
{
    protected $model;

    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }
}
