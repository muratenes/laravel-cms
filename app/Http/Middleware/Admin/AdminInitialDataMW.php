<?php

namespace App\Http\Middleware\Admin;

use App\Models\Ayar;
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
        $menus = config('admin.menus');
        $activeLanguages = Ayar::activeLanguages();
        View::share('menus', $menus);
        View::share('activeLanguages', $activeLanguages);

        return $next($request);
    }
}
