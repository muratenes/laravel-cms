<?php

use App\Models\Auth\Permission;
use App\Models\Auth\PermissionRole;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PermissionRole::truncate();
        Permission::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('roles')->insert([
            ['name' => 'super-admin'],
            ['name' => 'store'],
            ['name' => 'store-worker'],
            ['name' => 'customer'],
        ]);

        $permission_ids = []; // an empty array of stored permission IDs
        // iterate though all routes
        foreach (Route::getRoutes()->getRoutes() as $key => $route) {
            if (strpos($route->action['namespace'], 'App\Http\Controllers\Admin') !== false) {
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
                $name = explode("\\", $controller);
                $name = str_replace('Controller', '', end($name));
                if (!$permission_check) {
                    $permission = new Permission;
                    $permission->controller = $controller;
                    $permission->name = $name . '@' . $method;
                    $permission->method = $method;
                    $permission->save();
                    // add stored permission id in array
                    $permission_ids[] = $permission->id;
                }
            }

        }
        // find admin role.
        $admin_role = Role::where('name', 'super-admin')->first();
        // atache all permissions to admin role
        $admin_role->permissions()->attach($permission_ids);

        // customer roles
        $justSuperAdminExcludedControllers = Permission::select('id')->whereNotIn('name',Permission::justSuperAdminAccessThisControllers())->get('id')->pluck('id')->toarray();
        $customerRole = Role::where('name','customer')->first();
        $customerRole->permissions()->attach($justSuperAdminExcludedControllers);
    }
}
