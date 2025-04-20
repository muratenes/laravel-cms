<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ROLE_SUPER_ADMIN = 1;
    public const ROLE_VENDOR = 2;
    public const ROLE_MANAGER = 3;

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
            self::ROLE_VENDOR        => [self::ROLE_VENDOR, 'Mağaza'],
            self::ROLE_MANAGER      => [self::ROLE_MANAGER, 'Yönetici'],
        ];
    }

    public static function roleLabelStatic($param)
    {
        $list = self::listConstRolesWithId();

        return isset($list[$param]) ? $list[$param][1] : 'Kullanıcı';
    }
}
