<?php

namespace App\Providers;

use App\Listeners\LoggingListener;
use App\Models\Ayar;
use App\Models\Product\Urun;
use App\Models\Siparis;
use App\Observers\OrderObserver;
use App\Observers\UrunObserver;
use App\Repositories\Concrete\ElBaseRepository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer(['admin.*'], function ($view) {
            $languages = Ayar::activeLanguages();

            $view->with(compact('languages'));
        });
        Urun::observe(UrunObserver::class);
        Siparis::observe(OrderObserver::class);

        Blade::if('admin', function ($value) {
            return admin($value);
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(LoggingListener::class);

        $this->app->singleton(ElBaseRepository::class, function ($app, $parameters) {
            return new ElBaseRepository($parameters['model']);
        });
    }
}
