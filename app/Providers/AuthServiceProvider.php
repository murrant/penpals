<?php

namespace App\Providers;

use App\PenpalRole;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-penpals', function ($user) {
            return $user->role == PenpalRole::Admin;
        });

        Gate::define('view-stats', function ($user) {
            return $user->role == PenpalRole::Admin;
        });

        Gate::define('approve-requests', function ($user) {
            return $user->role == PenpalRole::Moderator || $user->role == PenpalRole::Admin;
        });
    }
}
