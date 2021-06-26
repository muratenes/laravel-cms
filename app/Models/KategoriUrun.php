<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriUrun extends Model
{
    public $timestamps = false;
    public $guarded = [];
    protected $perPage = 20;
    protected $table = 'kategori_urun';
}
