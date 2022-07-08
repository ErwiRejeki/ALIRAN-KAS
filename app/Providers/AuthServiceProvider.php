<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('AUTH_ADMINISTRATOR', function(User $user) {
            return $user->jabatan == 'administrator';
        });

        Gate::define('AUTH_PEMILIK', function(User $user) {
            return $user->jabatan == 'pemilik';
        });
        
        Gate::define('AUTH_KASIR', function(User $user) {
            return $user->jabatan == 'kasir';
        });

        Gate::define('AUTH_PEMBELIAN', function(User $user) {
            return $user->jabatan == 'pembelian';
        });

        //
    }
}
