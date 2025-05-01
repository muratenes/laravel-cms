<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $key
 * @property string $controller
 * @property string $method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Auth\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereController($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
     * Role::STORE kontrol edebileceği roller.
     *
     * @return string[]
     */
    public static function storeRoles()
    {
        return array_merge(self::basicRoutes(), [
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
            'Table@serviceComments',

            //            'Service@index',
            //            'CompanyService@index',
            //            'CompanyService@detail',
            //            'Table@companyServices',
        ]);
    }

    /**
     * Süper admin görmemesi gereken izinler.
     *
     * @return string[]
     */
    public static function adminExcludePermissions()
    {
        return [
            'ServiceStore@index',
            //            'ServiceComment@index',
        ];
    }

    /**
     * manager role permissions.
     *
     * @return string[]
     */
    public static function managerRoles()
    {
        return array_merge(self::basicRoutes(), [
            // Blog
            'Blog@index',
            'Blog@create',
            'Blog@edit',
            'Blog@update',
            'Blog@store',
            'Table@blogs',
            // Content
            'Content@index',
            'Content@create',
            'Content@update',
            'Content@store',
            'Content@delete',
            // User
            'User@index',
            'User@create',
            'User@update',
            'User@store',
            'User@delete',
        ]);
    }

    /*
     * basic admin routes
     *
     * @return string[]
     */
    private static function basicRoutes()
    {
        return [
            'Home@index',
            'Auth@login',
            'Auth@logout',
            'Category@subCategories',
        ];
    }
}
