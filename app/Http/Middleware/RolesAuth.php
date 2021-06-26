<?php

namespace App\Http\Middleware;

use App\Models\Auth\Role;
use Closure;

class RolesAuth
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
        $roleId = auth()->guard('admin')->user()->role_id;
        $role = Role::where('id', $roleId)->first();
        if (Role::ROLE_SUPER_ADMIN === $role->id) {
            return $next($request);
        }
        if ($role) {
            $permissions = $role->permissions;
            $actionName = class_basename($request->route()->getActionname());
            foreach ($permissions as $permission) {
                $actionNameWithoutController = str_replace('Controller', '', $actionName);
                if ($actionNameWithoutController === $permission->name || collect(self::allUserAccessToThisUrls())->contains($actionNameWithoutController)) {
                    return $next($request);
                }
            }
        } else {
            return redirect(route('homeView'))->withErrors('role bulunamadı');
        }

        return back()->withErrors('Bu işlemi görüntüleme/güncelleme veya silmek için yetkiniz yok');
    }

    public static function allUserAccessToThisUrls()
    {
        return [
            'Redirect@\Illuminate\Routing\RedirectController',
            'Kullanici@login',
            'Kullanici@logout',
            'Anasayfa@index',
            'Urun@getAllProductsForSearchAjax',
            'Urun@getSubAttributesByAttributeId',
            'Urun@getProductDetailWithSubAttributes',
        ];
    }
}
