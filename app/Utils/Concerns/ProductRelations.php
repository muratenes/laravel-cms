<?php

namespace App\Utils\Concerns;

use App\Models\Favori;
use App\Models\Kategori;
use App\Models\Product\UrunDescription;
use App\Models\Product\UrunDetail;
use App\Models\Product\UrunFirma;
use App\Models\Product\UrunImage;
use App\Models\Product\UrunMarka;
use App\Models\Product\UrunVariant;
use App\Models\Product\UrunYorum;

trait ProductRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Kategori', 'kategori_urun', 'product_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(UrunDescription::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail()
    {
        return $this->hasMany(UrunDetail::class, 'product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(UrunVariant::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany(Favori::class, 'favoriler', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        // todo : product_id yap relation name
        return $this->hasMany(UrunImage::class, 'product');
    }

    public function comments()
    {
        return $this->hasMany(UrunYorum::class, 'product_id')->take(100);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(UrunFirma::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(UrunMarka::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_category()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sub_category()
    {
        return $this->belongsTo(Kategori::class);
    }
}
