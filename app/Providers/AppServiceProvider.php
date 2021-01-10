<?php

namespace App\Providers;

use App\User;
use App\Listeners\LoggingListener;
use App\Models\Auth\Role;
use App\Models\Ayar;
use App\Models\Kategori;
use App\Models\Siparis;
use App\Models\Product\Urun;
use App\Observers\OrderObserver;
use App\Observers\UrunObserver;
use App\Repositories\Concrete\ElBaseRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['site.*'], function ($view) {
            $site = Ayar::getCache();
            $user = \Auth::user();
            $cacheCategories = Kategori::where(['active' => 1, 'parent_category_id' => null])->get();
            $view->with(compact('site', 'cacheCategories','user'));
        });
        View::composer(['admin.*'], function ($view) {
            $unreadCommentsCount = 0;
            $lastUnreadComments = [];
            $menus = $this->_getAdminMenus();
            $languages = Ayar::activeLanguages();

            $view->with(compact('lastUnreadComments', 'unreadCommentsCount', 'menus', 'languages'));
        });
        Urun::observe(UrunObserver::class);
        Siparis::observe(OrderObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LoggingListener::class);


        $this->app->singleton(ElBaseRepository::class, function ($app, $parameters) {
            return new ElBaseRepository($parameters['model']);
        });
    }

    private function _getAdminMenus()
    {
        try {
            $menus = config('admin.menus');
            $roleId = auth()->guard('admin')->user()->role_id;
            $role = Role::where('id', $roleId)->first();
            if ($role) {
                $userPermissions = $role->permissions;
                if ($userPermissions) {
                    $userPermissions = $role->permissions->pluck('name');
                    foreach ($menus as $index => $header) {
                        foreach ($header as $k => $head) {
                            if ($k != 'title') {
                                if (!$userPermissions->contains($head['permission'])) {
                                    unset($menus[$index][$k]);
                                }
                            }
                        }
                    }
                }
                return $menus;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }
}
