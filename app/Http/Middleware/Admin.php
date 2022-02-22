<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Admin
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
        $user = Auth::guard('admin')->user();
        if ($user && (Auth::guard('admin')->check() && $user->is_active && ($user->isSuperAdmin() || $user->isManager()))) {
            return $next($request);
        }
        Auth::guard('admin')->logout();

        return redirect(route('admin.login'));
    }
}
