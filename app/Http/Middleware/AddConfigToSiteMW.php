<?php

namespace App\Http\Middleware;

use App\Models\Builder\Menu;
use Closure;
use Illuminate\Support\Facades\View;

class AddConfigToSiteMW
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

        $menu = Menu::where(['parent_id' => null, 'status' => true])->with('children:id,title,href,parent_id')->get(); // todo : get from cache
        View::share('menus', $menu);

        return $next($request);
    }
}
