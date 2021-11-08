<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class Blog extends Model
{
    use MetaTaggable;

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
}
