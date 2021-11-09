<?php

namespace App\Models;

use App\Repositories\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class Category extends Model
{
    use Cachable;
    use HasFactory;
    use MetaTaggable;

    public const TYPES = [
        \App\Models\Blog::class,
        \App\Models\Content::class,
    ];

    protected $guarded = ['id'];

    protected $appends = ['type_label'];

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

    /**
     * get type label.
     *
     * @return string
     */
    public function getTypeLabelAttribute()
    {
        return __('admin.modules.category.' . $this->categorizable_type . '.title');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function (self $category) {
            return $category->slug = createSlugFromTitleByModel($category, $category->title, $category->id);
        });
    }
}
