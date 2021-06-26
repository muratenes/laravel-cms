<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    public $timestamps = false;
    protected $table = 'towns';
    protected $guarded = [];
}
