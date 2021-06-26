<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-address', function (User $user, \App\Models\KullaniciAdres $address) {
            return $user->id === $address->user_id;
        });

        Gate::define('edit-order', function (User $user, \App\Models\Siparis $order) {
            return $user->id === $order->basket->user_id;
        });
    }
}
