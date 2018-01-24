<?php

namespace Framework\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Data\Services\GetScopeFromPermissions;

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
        
        $scopeGetter = new GetScopeFromPermissions();
        $allScopes   = $scopeGetter->getAllScopes( false ); 
        Passport::tokensCan( $allScopes );
        Passport::routes();
    }
}
