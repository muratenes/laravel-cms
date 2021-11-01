<?php

namespace App\Models;

use App\Models\Region\Country;
use App\Models\Region\District;
use App\Models\Region\Neighborhood;
use App\Models\Region\State;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KullaniciAdres extends Model
{
    use SoftDeletes;

    public const TYPE_DELIVERY = 1;
    public const TYPE_INVOICE = 2;

    protected $table = 'kullanici_adres';
    protected $guarded = ['id'];
    protected $perPage = 10;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * adresin metin olarak getirir.
     */
    public function getAddressTextAttribute()
    {
        $districtLabel = ($this->neighborhood ? $this->neighborhood->title : '') . ' ' . $this->district ? $this->district->title : '';
        $stateTitle = $this->state ? $this->state->title : '';
        $countryTitle = $this->country ? $this->country->title : '';

        return "{$this->adres} {$districtLabel} {$stateTitle}/{$countryTitle}";
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }
}
