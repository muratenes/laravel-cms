<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    const MODULE_NAME = "banner";

    protected $perPage = 20;
    protected $table = "banner";
    public $timestamps = true;
    public $guarded = [];


}
