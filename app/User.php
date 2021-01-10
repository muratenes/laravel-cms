<?php

namespace App;

use App\Models\Auth\Role;
use App\Models\Favori;
use App\Models\KullaniciAdres;
use App\Utils\Concerns\Models\UserNotifications;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HasLocalePreference
{
    use Notifiable;
    use UserNotifications;

    protected $fillable = [
        'name', 'surname', 'email', 'password', 'activation_code', 'is_active', 'is_admin', 'role_id','locale'
    ];

    protected $hidden = [
        'password', 'activation_code',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(KullaniciAdres::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice_addresses()
    {
        return $this->hasMany(KullaniciAdres::class, 'user_id', 'id')->where('type', KullaniciAdres::TYPE_INVOICE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function default_address()
    {
        return $this->belongsTo(KullaniciAdres::class, 'default_address_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Favori::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function default_invoice_address()
    {
        return $this->belongsTo(KullaniciAdres::class, 'default_invoice_address_id', 'id');
    }


    /**
     * get full name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }

    /**
     * @return mixed
     */
    public function getLocaleIyzicoAttribute()
    {
        return $this->locale == 'tr' ? 'tr' : 'en';
    }

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
    {
        return $this->locale;
    }
}
