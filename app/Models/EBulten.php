<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EBulten extends Model
{
    public $timestamps = true;
    public $guarded = [];
    protected $perPage = 20;
    protected $table = 'ebulten';
}
