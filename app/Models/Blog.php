<?php

namespace App\Models;

use App\User;
use App\Utils\Concerns\Models\Imageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class Blog extends Model
{
    use Imageable;
    use MetaTaggable;
    use SoftDeletes;

    public const MODULE_NAME = 'blog';
    public const LANG_FIELDS = ['title', 'description', 'tags'];

    public const IMAGE_RESIZE = null;
    public $timestamps = true;
    public $guarded = [];
    protected $perPage = 20;
    protected $table = 'blog';

    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id', 'id');
    }

    /**
     * Get the another languages model instances.
     */
    public function languages()
    {
        return $this->morphMany(MultiLanguage::class, 'languageable');
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function (self $blog) {
            return $blog->slug = createSlugFromTitleByModel($blog, $blog->title, $blog->id);
        });
    }
}
