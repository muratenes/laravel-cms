<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class UrunInfo extends Model
{
    public $timestamps = false;
    protected $table = 'urunler_info';
    protected $guarded = ['id'];

    protected $casts = [
        'properties'     => 'array',
        'oems'           => 'array',
        'supported_cars' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Urun::class, 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(UrunMarka::class, 'brand_id')->withDefault();
    }

    public function company()
    {
        return $this->belongsTo(UrunFirma::class, 'company_id')->withDefault();
    }

//    public function setPropertiesAttribute($value)
//    {
////        $properties = [];
////        foreach ($value as $array_item) {
////            if (!is_null($array_item['key'])) {
////                $properties[] = $array_item;
////            }
////        }
////        $this->attributes['properties'] = json_encode($properties);
//    }
}
