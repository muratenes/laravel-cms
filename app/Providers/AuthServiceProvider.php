<?php

namespace App\Providers;

use App\Models\Blog;
use App\Policies\BlogPolicy;
use App\Policies\UserPolicy;
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
        User::class => UserPolicy::class,
        Blog::class => BlogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-address', function (User $user, \App\Models\UserAddress $address) {
            return $user->id === $address->user_id;
        });

        Gate::define('edit-order', function (User $user, \App\Models\Order $order) {
            return $user->id === $order->basket->user_id;
        });

        Gate::before(function (User $user) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
    }
}
