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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerJemaatIndukPolicies();
        $this->registerAsetJemaatPolicies();
        $this->registerUserPolicies();
        $this->registerAsetJemaatStatReportPolicies();
    }

    protected function registerJemaatIndukPolicies()
    {
        Gate::define('create-new-jemaat', function ($user) {

            //$user->hasAccess(['create-new-jemaat']);
            //$user->profile->id = '';
            return $user->roles()->first()->id <= \App\Models\Role::ROLE_MUPEL;
            //return true;
        });

        Gate::define('edit-jemaat', function ($user, \App\Models\JemaatInduk $jemaatInduk) {

            if ( isset($user->profile->access_data['jemaat']) )
                return $user->profile->access_data['jemaat'] == $jemaatInduk->id;

            if ( isset($user->profile->access_data['mupel']) )
                return $user->profile->access_data['mupel'] == $jemaatInduk->mupel->id;

            if ( $user->roles()->first()->id <= \App\Models\Role::ROLE_SINODE )
                return true;

            return false;
        });

        Gate::define('delete-jemaat', function ($user, \App\Models\JemaatInduk $jemaatInduk) {

            if ( isset($user->profile->access_data['mupel']) )
                return $user->profile->access_data['mupel'] == $jemaatInduk->mupel->id;

            if ( $user->roles()->first()->id <= \App\Models\Role::ROLE_SINODE )
                return true;

            return false;
        });
    }

    protected function registerAsetJemaatPolicies()
    {
        Gate::define('create-new-aset-jemaat', function ($user) {
            return $user->roles()->first()->id <= \App\Models\Role::ROLE_JEMAAT;
        });

        Gate::define('edit-aset-jemaat', function ($user, \App\Models\AsetJemaat $asetJemaat) {

            if ( isset($user->profile->access_data['jemaat']) )
                return $user->profile->access_data['jemaat'] == $asetJemaat->jemaat->id;

            if ( isset($user->profile->access_data['mupel']) )
                return $user->profile->access_data['mupel'] == $asetJemaat->jemaat->mupel->id;

            if ( $user->roles()->first()->id <= \App\Models\Role::ROLE_SINODE )
                return true;

            return false;
        });

        Gate::define('delete-aset-jemaat', function ($user, \App\Models\AsetJemaat $asetJemaat) {

            if ( isset($user->profile->access_data['jemaat']) )
                return $user->profile->access_data['jemaat'] == $asetJemaat->jemaat->id;

            if ( isset($user->profile->access_data['mupel']) )
                return $user->profile->access_data['mupel'] == $asetJemaat->jemaat->mupel->id;

            if ( $user->roles()->first()->id <= \App\Models\Role::ROLE_SINODE )
                return true;

            return false;
        });
    }

    protected function registerUserPolicies()
    {
        Gate::define('create-user', function ($user) {
            return $user->roles()->first()->id == \App\Models\Role::ROLE_ADMIN;
        });

        Gate::define('update-user', function ($user) {
            return $user->roles()->first()->id <= \App\Models\Role::ROLE_ADMIN;
        });

        Gate::define('show-user', function ($user) {
            return $user->roles()->first()->id <= \App\Models\Role::ROLE_ADMIN;
        });

        Gate::define('delete-user', function ($user) {
            return $user->roles()->first()->id <= \App\Models\Role::ROLE_ADMIN;
        });
    }

    protected function registerAsetJemaatStatReportPolicies()
    {
        Gate::define('show-aset-jemaat-mupel', function ($user) {
            return $user->roles()->first()->id <= \App\Models\Role::ROLE_MUPEL;
        });

        Gate::define('show-aset-jemaat-induk', function ($user) {
            return $user->roles()->first()->id <= \App\Models\Role::ROLE_JEMAAT;
        });
    }
}