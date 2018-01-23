<?php

namespace Framework\Providers;

use Laravel\Passport\Passport;
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
        'Framework\Model' => 'Framework\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensCan([
            'companies-read-allowed' => 'Read the companies',
            'companies-write-allowed' => 'Modify the companies',
            'companies-delete-allowed' => 'Delete companies'
        ]);
        Passport::routes();
    }
}
