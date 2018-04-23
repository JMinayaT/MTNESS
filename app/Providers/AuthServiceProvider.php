<?php

namespace App\Providers;

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
        'Modules\Auth\Models\Role' => 'Modules\Auth\Policies\RolePolicy',
        'Modules\Auth\Models\User' => 'Modules\Auth\Policies\UserPolicy',
        'Modules\System\Models\Lang' => 'Modules\System\Policies\LangPolicy',
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
