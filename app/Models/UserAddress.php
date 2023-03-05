<?php

namespace App\Models;

use App\Models\Region\Country;
use App\Models\Region\District;
use App\Models\Region\Neighborhood;
use App\Models\Region\State;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    public const TYPE_DELIVERY = 1;
    public const TYPE_INVOICE = 2;

    protected $guarded = ['id'];
    protected $perPage = 10;

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function neighborhood(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get user full address.
     */
    public function getAddressTextAttribute(): string
    {
        $districtLabel = ($this->neighborhood ? $this->neighborhood->title : '') . ' ' . $this->district ? $this->district->title : '';
        $stateTitle = $this->state ? $this->state->title : '';
        $countryTitle = $this->country ? $this->country->title : '';

        return "{$this->adres} {$districtLabel} {$stateTitle}/{$countryTitle}";
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }
}
