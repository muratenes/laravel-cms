<?php

namespace App\Providers;

use App\Models\Product\Product;
use App\Observers\UrunObserver;
use Illuminate\Support\ServiceProvider;

class ObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Product::observe(UrunObserver::class);
    }

    /**
     * Register services.
     */
    public function register()
    {
    }
}
