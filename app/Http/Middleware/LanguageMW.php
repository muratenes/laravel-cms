<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LanguageMW
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
        $sessionValue = session()->get('locale', null);
        if ($sessionValue && config('admin.multi_lang')) {
            App::setLocale($sessionValue);
        } else {
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
