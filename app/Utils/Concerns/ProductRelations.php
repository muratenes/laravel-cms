<?php

namespace App\Utils\Concerns;


trait ProductRelations
{
    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'category_product', 'product_id', 'category_id');
    }

    public function detail(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductDetail::class, 'product');
    }

    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function favorites(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Favorite::class, 'favorites', 'product_id');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductImage::class, 'product');
    }

    public function comments()
    {
        return $this->hasMany(ProductComment::class, 'product_id')->take(100);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductCompany::class);
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function parent_category()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function sub_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
