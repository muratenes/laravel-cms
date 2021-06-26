<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referance extends Model
{
    public const MODULE_NAME = 'reference';

    public const IMAGE_QUALITY = 60;
    public const IMAGE_RESIZE = null;
    public $timestamps = false;

    protected $table = 'referanslar';
    protected $guarded = [];
}
