<?php

namespace App\Providers;

use App\Interfaces\AddressRepositoryInterface;
use App\Interfaces\HostRepositoryInterface;
use App\Interfaces\HotelRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AddressRepository;
use App\Repositories\HostRepository;
use App\Repositories\HotelRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //user repository
        // $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
