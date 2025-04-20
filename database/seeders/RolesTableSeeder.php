<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\PermissionRole;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->updateOrCreateRoles();

        $permission_ids = []; // an empty array of stored permission IDs
        // iterate though all routes
        foreach (Route::getRoutes()->getRoutes() as $key => $route) {
            if (false !== mb_strpos($route->action['namespace'], 'App\Http\Controllers\Admin')) {
                // get route action
                $action = $route->getActionname();
                // separating controller and method
                $_action = explode('@', $action);

                $controller = $_action[0];
                $method = end($_action);

                // check if this permission is already exists
                $permission_check = Permission::where(
                    ['controller' => $controller, 'method' => $method]
                )->first();
                $name = explode('\\', $controller);
                $name = str_replace('Controller', '', end($name));
                if (! $permission_check) {
                    $permission = Permission::firstOrCreate(
                        ['name' => $name . '@' . $method],
                        [
                            'controller' => $controller,
                            'method'     => $method,
                        ]
                    );
                    // add stored permission id in array
                    $permission_ids[] = $permission->id;
                }
            }
        }
        // SYNC ADMIN ROLES.
        $admin_role = Role::where('name', 'super-admin')->first();
        $adminPermissions = Permission::select('id')->whereNotIn('name', Permission::adminExcludePermissions())->get('id')->pluck('id')->toarray();
        $admin_role->permissions()->sync($adminPermissions);

        // SYNC STORE ROLES.
        $storePermissions = Permission::select('id')->whereIn('name', Permission::storeRoles())->get('id')->pluck('id')->toarray();
        $storeRole = Role::where('name', 'vendor')->first();
        $storeRole->permissions()->sync($storePermissions);

        // SYNC MANAGER ROLES.
        $managerPermissions = Permission::select('id')->whereIn('name', Permission::managerRoles())->get('id')->pluck('id')->toarray();
        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->permissions()->sync($managerPermissions);
    }

    private function updateOrCreateRoles()
    {
        $roles = [
            ['name' => 'super-admin'],
            ['name' => 'vendor'],
            ['name' => 'manager'],
        ];
        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role], $role);
        }
    }
}
