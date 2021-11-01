<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = ['id'];

    /**
     * Get all of the banners that are assigned this tag.
     */
    public function banners()
    {
        return $this->morphedByMany(Banner::class, 'taggable');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function (self $tag) {
            return $tag->slug = createSlugFromTitleByModel($tag, $tag->title, $tag->id);
        });
    }
}
