<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    public const MODULE_NAME = 'content';
    public const IMAGE_QUALITY = 60;
    public const IMAGE_RESIZE = null;

    protected $table = 'icerik_yonetim';
    protected $perPage = 20;
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subContents()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
