<?php

namespace App\Http\Middleware\Admin;

use Illuminate\Support\Facades\View;

class AdminCountsMW
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $counts = [
            'order' =>0,
        ];
        View::share('counts', $counts);

        return $next($request);
    }
}
