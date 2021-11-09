<?php

namespace App\Models;

use App\Repositories\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Cachable;
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get all of the banners that are assigned this tag.
     */
    public function banners(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Banner::class, 'categorizable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_category_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function (self $category) {
            return $category->slug = createSlugFromTitleByModel($category, $category->title, $category->id);
        });
    }
}
