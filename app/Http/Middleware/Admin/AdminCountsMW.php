<?php

namespace App\Http\Middleware\Admin;

use Closure;
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
    public function handle($request, Closure $next)
    {
        $counts = [
            // todo : count variables
        ];
        View::share('counts', $counts);

        return $next($request);
    }
}
