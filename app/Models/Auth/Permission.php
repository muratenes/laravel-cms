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

    public static function justSuperAdminAccessThisControllers()
    {
        return [
            'Role@list',
            'Role@newOrEditForm',
            'Role@save',
            'Role@delete'
        ];
    }
}
