<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImages extends Model
{
    public $timestamps = false;
    protected $perPage = 20;
    protected $guarded = [];


    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    }
}
