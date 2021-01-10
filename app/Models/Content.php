<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    const MODULE_NAME = 'content';

    protected $table = 'icerik_yonetim';
    protected $perPage = 20;
    protected $guarded = [];
    const  IMAGE_QUALITY = 60;
    const  IMAGE_RESIZE = null;

    public function parentContent()
    {
        return $this->belongsTo(Content::class, 'parent', 'id');
    }
    public function subContents()
    {
        return $this->hasMany(Content::class, 'parent', 'id');
    }
}
