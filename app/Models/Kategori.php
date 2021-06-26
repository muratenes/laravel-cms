<?php

namespace App\Models;

use App\Models\Product\KategoriDescription;
use App\Models\Product\Urun;
use App\Utils\Concerns\Admin\CategoryLanguageAttributeConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use CategoryLanguageAttributeConcern;
    use SoftDeletes;

    public const MODULE_NAME = 'category';
    public $timestamps = false;
    public $guarded = ['id'];

    protected $appends = ['lang'];

    protected $perPage = 20;
    protected $table = 'kategoriler';

    /**
     * diğer dillerdeki kategori karşılıkları.
     *
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
        return $this->belongsTo(self::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sub_categories()
    {
        return $this->hasMany(self::class, 'parent_category_id')->orderBy('row');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Urun::class, 'kategori_urun', 'category_id', 'product_id');
    }

    /**
     * mevcut dildeki kategoriyi getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|Model|object
     */
    public function getLangAttribute()
    {
        if (! $this->getRelationValue('descriptions')) {
            return $this->getOriginal();
        }
        $langDescription = $this->getRelation('descriptions')->firstWhere('lang', '=', curLangId());

        return $langDescription ? array_merge($this->getOriginal(), $langDescription->getOriginal()) : $this->getOriginal();
    }
}
