<?php

namespace App\Providers;

use App\Category;
use App\Policies\CategoryPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use App\Policies\WalletPolicy;
use App\Transaction;
use App\User;
use App\Wallet;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Wallet::class => WalletPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
