<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property-read Model|\Eloquent $languageable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MultiLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MultiLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MultiLanguage query()
 * @mixin \Eloquent
 */
class MultiLanguage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the owning languageable model.
     */
    public function languageable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $languageableType = $model->languageable_type;
            $fields = $languageableType::LANG_FIELDS;
            if (! $fields) {
                throw new \Exception("langFields variable must be added to {$languageableType} model.");
            }
            $model->attributes['data'] = collect($model->data)->only($fields);
        });
    }
}
