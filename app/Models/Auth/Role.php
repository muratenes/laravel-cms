<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Auth\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
