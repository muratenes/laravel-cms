<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class Blog extends Model
{
    use MetaTaggable;
    use SoftDeletes;

    public const MODULE_NAME = 'blog';

    public const IMAGE_QUALITY = 80;
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
}
