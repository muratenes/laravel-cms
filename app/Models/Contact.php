<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "iletisim";
    protected $guarded = [];
    public $timestamps = true;
    protected $perPage = 1;
}
