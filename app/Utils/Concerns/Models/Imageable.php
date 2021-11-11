<?php

namespace App\Utils\Concerns\Models;

use App\Models\Image;

trait Imageable
{
    /**
     * Get the company image.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->latest();
    }
}
