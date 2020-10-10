<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\ExpenseApplication;
use App\Policies\ExpenseApplicationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        ExpenseApplication::class => ExpenseApplicationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        //管理者のみ許可
        Gate::define('admin', function($user){
            return $user->role->role_code == 'admin';
        });
        //全ユーザーを許可
        Gate::define('all_user', function($user){
            return $user->role->role_code == 'admin' || 'user';
        });
       
    }
}
