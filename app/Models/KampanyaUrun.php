<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KampanyaUrun extends Model
{
    public $timestamps = false;
    protected $table = 'kampanya_urunler';
    protected $guarded = [];

    public function campaign()
    {
        return $this->belongsTo(Kampanya::class, 'campaign_id', 'id');
    }
}
