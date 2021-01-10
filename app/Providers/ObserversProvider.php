<?php

namespace App\Providers;

use App\Models\Product\Urun;
use App\Observers\UrunObserver;
use Illuminate\Support\ServiceProvider;

class ObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Urun::observe(UrunObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
