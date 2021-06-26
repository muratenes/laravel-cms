<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\App;

class SetUserLocaleMW
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
        $user = $request->user('admin');
        if ($user && $user->locale) {
            App::setLocale($user->locale);
        }

        return $next($request);
    }
}
