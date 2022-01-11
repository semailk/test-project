<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

//        Gate::define('sales', function (User $user, Client $client) {;
//
//            return $client->user_id === $user->id;
//        });
//        Gate::define('senior_sales', function (User $user, Client $client) {
//            $roleId = Role::where('name', 'senior_sales')->first()->id;
//
//            return $client->user_id === $user->id;
//        });
//        Gate::define('head_of_sales', function (User $user, Client $client) {
//            $roleId = Role::where('name', 'head_of_sales')->first()->id;
//
//            return $client->user_id === $user->id;
//        });
//        Gate::define('admin', function (User $user, Client $client) {
//            $roleId = Role::where('name', 'admin')->first()->id;
//
//            return $client->user_id === $user->id;
//        });
    }
}
