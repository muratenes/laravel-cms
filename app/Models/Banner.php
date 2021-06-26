<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public const MODULE_NAME = 'banner';
    public $timestamps = true;
    public $guarded = [];

    protected $perPage = 20;
    protected $table = 'banner';
}
