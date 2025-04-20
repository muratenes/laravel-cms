<?php

namespace App\Providers;

use App\Listeners\LoggingListener;
use App\Models\Config;
use App\Repositories\Concrete\ElBaseRepository;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap();

        View::composer(['admin.*'], function ($view) {
            $languages = Config::activeLanguages();

            $view->with(compact('languages'));
        });

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
