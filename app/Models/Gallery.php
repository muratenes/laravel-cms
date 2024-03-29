<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public const MODULE_NAME = 'gallery';
    public $timestamps = true;
    protected $guarded = [];
    protected $perPage = 10;

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GalleryImage::class, 'gallery_id', 'id')->orderByDesc('id');
    }

    public function imagesCount(): int
    {
        return $this->hasMany(GalleryImage::class, 'gallery_id', 'id')->count();
    }
}
