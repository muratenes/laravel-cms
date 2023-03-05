<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $perPage = 20;
    protected $table = 'faq';
}
