<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    protected $table = 'cities';
    protected $guarded = [];

    public function towns()
    {
        return $this->hasMany(Town::class, 'city', 'id');
    }
}
