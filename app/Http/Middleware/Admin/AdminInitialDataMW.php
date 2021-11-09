<?php

namespace App\Http\Middleware\Admin;

use App\Models\Auth\Role;
use App\Models\Ayar;
use App\Models\Log;
use Closure;
use Illuminate\Support\Facades\View;

class AdminInitialDataMW
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $activeLanguages = Ayar::activeLanguages();
        View::share('menus', $this->_getAdminMenus());
        View::share('activeLanguages', $activeLanguages);

        return $next($request);
    }

    private function _getAdminMenus()
    {
        try {
            $menus = config('admin.menus');
            $roleId = loggedAdminUser()->role_id;
            $role = Role::where('id', $roleId)->first();
            if ($role) {
                $userPermissions = $role->permissions;
                if ($userPermissions) {
                    $userPermissions = $role->permissions->pluck('name');
                    foreach ($menus as $index => $header) {
                        foreach ($header as $k => $head) {
                            if ('title' !== $k) {
                                if (! $userPermissions->contains($head['permission'])) {
                                    unset($menus[$index][$k]);
                                }
                            }
                        }
                    }
                }

                return $menus;
            }
        } catch (\Exception $exception) {
            Log::addLog($exception->getMessage(), $exception, Log::TYPE_GENERAL);

            return null;
        }
    }
}
