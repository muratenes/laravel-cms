<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolesAuth;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Repositories\Interfaces\KullaniciInterface;

class RoleController extends Controller
{
    protected KullaniciInterface $model;

    public function __construct(KullaniciInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $list = $this->model->getAllRolesWithPagination();

        return view('admin.roles.listRoles', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $item = new Role();
        $allPermissions = Permission::all();
        $userPermission = [];
        if (0 !== $id) {
            $item = $this->model->getRoleById($id);
            if ($item) {
                $userPermission = $item->permissions->pluck('id');
            }
        }

        return view('admin.roles.newOrEditRoles', compact('item', 'allPermissions', 'userPermission'));
    }

    // todo : code refactor
    public function save($id = 0)
    {
        $request_data = request()->only('name', 'description');
        $allUserAccessThisUrls = RolesAuth::allUserAccessToThisUrls();
        $allUserAccessThisUrls = Permission::select('id')->whereIn('name', $allUserAccessThisUrls)->get()->pluck('id');
        $roles = request('roles');
        $roles = array_merge($roles, $allUserAccessThisUrls->toarraY());
        $roles = array_unique($roles);
        if (0 !== $id) {
            $entry = $this->model->updateRole($id, $request_data);
            if ($entry) {
                $entry->permissions()->sync($roles);
            }
        } else {
            $entry = $this->model->createRole($request_data);
            if ($entry) {
                $entry->permissions()->attach($roles);
            }
        }
        if (null !== $entry) {
            return redirect(route('admin.role.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete($id)
    {
        if (\in_array($id, [Role::ROLE_SUPER_ADMIN, Role::ROLE_CUSTOMER, Role::ROLE_STORE, Role::ROLE_STORE_WORKER], true)) {
            return redirect(route('admin.roles'))->withErrors('you can not delete this role');
        }
        $this->model->deleteRole($id);

        return redirect(route('admin.roles'));
    }
}
