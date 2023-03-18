<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Auth\Role;
use App\Models\Log;
use App\Repositories\Interfaces\UserInterface;
use App\User;

class ElUserDal extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAllRolesWithPagination()
    {
        return Role::orderByDesc('id')->simplePaginate();
    }

    public function getRoleById($id)
    {
        return Role::find($id);
    }

    public function createRole($data)
    {
        try {
            return Role::create($data);
        } catch (\Exception $exception) {
            Log::addLog('role eklerken hata oluştu', $exception, Log::TYPE_CREATE_OBJECT);
        }
    }

    public function updateRole($id, $data)
    {
        try {
            $role = $this->getRoleById($id);
            if ($role) {
                $role->update($data);

                return $role;
            }
        } catch (\Exception $exception) {
            Log::addLog('role güncellerken hata oluştu', $exception, Log::TYPE_CREATE_OBJECT);
        }
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        if (! $role) {
            return false;
        }

        $role->permissions()->detach();
        $role->delete();

        return true;
    }
}
