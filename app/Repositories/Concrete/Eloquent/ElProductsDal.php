<?php

namespace App\Repositories\Concrete\Eloquent;


use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ElProductsDal
{
    use ResponseTrait;
}
