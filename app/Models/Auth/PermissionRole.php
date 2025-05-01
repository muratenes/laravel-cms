<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $permission_id
 * @property int $role_id
 * @property-read \App\Models\Auth\Permission $permission
 * @property-read \App\Models\Auth\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionRole whereRoleId($value)
 * @mixin \Eloquent
 */
class PermissionRole extends Model
{
    protected $table = 'permission_role';
    protected $guarded = [];
    protected $perPage = 10;

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
