<?php

namespace App\Models;

use App\Models\Product\KategoriDescription;
use App\Models\Product\Urun;
use App\Utils\Concerns\Admin\CategoryLanguageAttributeConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Kategori extends Model
{
    use SoftDeletes;
    use CategoryLanguageAttributeConcern;

    protected $appends = ['title_lang', 'spot_lang'];

    const MODULE_NAME = 'category';

    protected $perPage = 20;
    protected $table = "kategoriler";
    public $timestamps = false;
    public $guarded = ['id'];


    /**
     * diğer dillerdeki kategori karşılıkları
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(KategoriDescription::class, 'category_id', 'id')->orderBy('lang');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_category()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sub_categories()
    {
        return $this->hasMany(Kategori::class, 'parent_category_id')->orderBy('row');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Urun::class, 'kategori_urun', 'category_id', 'product_id');
    }


}
