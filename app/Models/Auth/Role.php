<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ROLE_SUPER_ADMIN = 1;
    public const ROLE_STORE = 2;
    public const ROLE_STORE_WORKER = 3;
    public const ROLE_CUSTOMER = 4;
    public const ROLE_MANAGER = 5;

    protected $table = 'roles';
    protected $guarded = [];
    protected $perPage = 10;

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Auth\Permission')->orderBy('name');
    }

    public function users()
    {
        return $this->hasMany('App\Models\Auth\User');
    }

    public static function listConstRolesWithId()
    {
        return [
            self::ROLE_SUPER_ADMIN  => [self::ROLE_SUPER_ADMIN, 'Süper Admin'],
            self::ROLE_STORE        => [self::ROLE_STORE, 'Mağaza'],
            self::ROLE_STORE_WORKER => [self::ROLE_STORE_WORKER, 'Mağaza Çalışan'],
            self::ROLE_CUSTOMER     => [self::ROLE_CUSTOMER, 'Son Kullanıcı'],
            self::ROLE_MANAGER      => [self::ROLE_MANAGER, 'Yönetici'],
        ];
    }

    public static function roleLabelStatic($param)
    {
        $list = self::listConstRolesWithId();

        return isset($list[$param]) ? $list[$param][1] : 'Kullanıcı';
    }
}
