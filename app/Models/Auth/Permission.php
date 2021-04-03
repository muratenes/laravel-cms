<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $guarded = [];
    protected $perPage = 10;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    /**
     * Role::STORE kontrol edebileceği roller
     * @return string[]
     */
    public static function storeRoles()
    {
        return [
            'Anasayfa@index',
            'Kullanici@login',
            'Kullanici@logout',

            // Service
            'ServiceStore@index',
            'Table@services',
            'Service@services',
            'Service@create',
            'Service@update',
            'Service@edit',
            'Service@store',
            'Service@destroy',
            'Service@deleteImage',
            'Service@appointments',
            'Service@createStoreAppointment',
            'Service@detail',
            'Service@appointmentDetail',
            'Service@updateStoreAppointment',
            'Service@deleteStoreAppointment',

            // ServiceComment
            'ServiceComment@index',
            'ServiceComment@edit',

            // Tables
            'Table@serviceComments'

//            'Service@index',
//            'CompanyService@index',
//            'CompanyService@detail',
//            'Table@companyServices',
        ];
    }

    /**
     * Süper admin görmemesi gereken izinler
     * @return string[]
     */
    public static function adminExcludePermissions()
    {
        return [
            'ServiceStore@index',
//            'ServiceComment@index',
        ];
    }
}
