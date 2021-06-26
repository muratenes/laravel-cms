<?php

namespace App\Providers;

use App\Models\Product\Urun;
use App\Observers\UrunObserver;
use Illuminate\Support\ServiceProvider;

class ObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Urun::observe(UrunObserver::class);
    }

    /**
     * Register services.
     */
    public function register()
    {
    }
}
