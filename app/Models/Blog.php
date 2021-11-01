<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function categories()
    {
        return $this->morphMany(Category::class, 'categorizable');
    }
}
