<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KampanyaUrun extends Model
{
    protected $table = "kampanya_urunler";
    protected $guarded = [];
    public $timestamps = false;

    public function campaign()
    {
        return $this->belongsTo(Kampanya::class, 'campaign_id', 'id');
    }
}
