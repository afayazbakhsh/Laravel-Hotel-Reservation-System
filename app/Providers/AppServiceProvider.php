<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ConvertServiceInterface;
use App\Services\ConvertService;
use App\Models\Host;
use App\Observers\HostObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //telescop package
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        //services
        $this->app->bind(ConvertServiceInterface::class, ConvertService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Host::observe(HostObserver::class);
    }
}
