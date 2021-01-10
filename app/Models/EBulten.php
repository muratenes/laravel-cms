<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EBulten extends Model
{
    protected $perPage = 20;
    protected $table = "ebulten";
    public $timestamps = true;
    public $guarded = [];
}
