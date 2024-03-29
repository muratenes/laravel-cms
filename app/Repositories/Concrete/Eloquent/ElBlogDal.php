<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Blog;
use App\Repositories\Interfaces\BlogInterface;

class ElBlogDal extends BaseRepository implements BlogInterface
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }
}
