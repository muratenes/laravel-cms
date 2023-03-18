<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Product\ProductComment;
use App\Repositories\Interfaces\ProductCommentInterface;

class ElProductCommentDal extends BaseRepository implements ProductCommentInterface
{
    public function __construct(ProductComment $model)
    {
        parent::__construct($model);
    }
}
