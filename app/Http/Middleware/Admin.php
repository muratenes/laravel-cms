<?php

namespace App\Http\Middleware;

use App\Models\Auth\Role;
use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('admin')->user();
        if ($user && (( Auth::guard('admin')->check() && $user->is_active && $user->role_id == Role::ROLE_SUPER_ADMIN) || $user->is_admin)) {
            return $next($request);
        }
        return redirect(route('admin.login'));
    }
}
