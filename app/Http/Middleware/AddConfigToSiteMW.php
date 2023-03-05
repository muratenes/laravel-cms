<?php

namespace App\Http\Middleware;

use App\Models\Builder\Menu;
use App\Models\Config;
use App\Models\Kategori;
use Illuminate\Support\Facades\View;

class AddConfigToSiteMW
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
        $menu = Menu::where(['parent_id' => null, 'status' => true])->with('children:id,title,href,parent_id')->get();
        $site = Config::getCache();
        $user = \Auth::user();
        $cacheCategories = $this->getCategories();

        View::share('menus', $menu);
        View::share('site', $site);
        View::share('user', $user);
        View::share('cacheCategories', $cacheCategories);

        return $next($request);
    }

    private function getCategories()
    {
        return \Cache::remember('categories.all', 20, function () {
            return Kategori::with(['languages', 'sub_categories.languages', 'sub_categories.sub_categories'])
                ->where(['active' => 1, 'parent_category_id' => null])->get();
        });
    }
}
