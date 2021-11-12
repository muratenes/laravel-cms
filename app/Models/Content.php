<?php

namespace App\Models;

use App\Utils\Concerns\Models\Imageable;
use App\Utils\Concerns\Models\Languageable;
use Illuminate\Database\Eloquent\Model;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class Content extends Model
{
    use Imageable;
    use Languageable;
    use MetaTaggable;

    public const MODULE_NAME = 'content';
    public const IMAGE_RESIZE = null;

    protected $table = 'icerik_yonetim';
    protected $perPage = 20;
    protected $guarded = ['id'];
    protected $appends = ['lang_icon'];

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
