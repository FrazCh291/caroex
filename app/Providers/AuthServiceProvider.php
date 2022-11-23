<?php

namespace App\Providers;

use App\Models\Deal;
use App\Models\Company;
use App\Models\Package;
use App\Policies\DealPolicy;
use App\Models\Subscription;
use App\Policies\CompanyPolicy;
use App\Policies\PackagePolicy;
use App\Policies\SupplierPolicy;
use App\Policies\SubscriptionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Models\Company' => 'App\Policies\CompanyPolicy',
        Deal::class => DealPolicy::class,
        Package::class => PackagePolicy::class,
        Company::class => CompanyPolicy::class,
        Subscription::class => SubscriptionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
//        __DIR__.'/../config/imap.php' => config_path('imap.php');
        //
    }
}
