<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    const MODULES = [
        'product',
        'category',
        'content_management'
    ];

    /**
     * üst menü
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * üst menü
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descriptions()
    {
        return $this->hasMany(MenuDescription::class, 'menu_id', 'id');
    }

}
