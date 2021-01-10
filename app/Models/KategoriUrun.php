<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriUrun extends Model
{
    protected $perPage = 20;
    protected $table = "kategori_urun";
    public $timestamps = false;
    public $guarded = [];
}
