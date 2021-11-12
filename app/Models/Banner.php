<?php

namespace App\Models;

use App\Utils\Concerns\Models\Languageable;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use Languageable;

    public const MODULE_NAME = 'banner';
    public $timestamps = true;
    public $guarded = [];

    protected $perPage = 20;
    protected $table = 'banner';
    protected $appends = ['lang_icon'];

    /**
     * Get all of the tags for the banner.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get all of the categories for the banner.
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }
}
