<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    const MODULE_NAME = 'blog';
    protected $perPage = 20;
    protected $table = "blog";
    public $timestamps = true;
    public $guarded = [];

    protected $casts = [
        'tags' => 'array'
    ];

    const  IMAGE_QUALITY = 80;
    const  IMAGE_RESIZE = null;

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'category_blog', "blog_id", 'category_id');
    }
}
