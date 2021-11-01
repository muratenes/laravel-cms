<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    /**
     * Get all of the banners that are assigned this tag.
     */
    public function banners()
    {
        return $this->morphedByMany(Banner::class, 'categorizable');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function (self $category) {
            return $category->slug = createSlugFromTitleByModel($category, $category->title, $category->id);
        });
    }
}
