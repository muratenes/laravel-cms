<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Model;

class MenuDescription extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    /**
     * üst menü
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function main()
    {
        return $this->belongsTo(Menu::class);
    }
}
