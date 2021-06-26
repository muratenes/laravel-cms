<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = true;
    protected $table = 'iletisim';
    protected $guarded = [];
    protected $perPage = 1;
}
