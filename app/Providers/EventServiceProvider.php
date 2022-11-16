<?php

namespace App\Providers;

use App\Events\Host\HostRequestedRegistration;
use App\Events\Hotel\HotelRequestedRegistration;
use App\Events\Hotel\UpdateHotel;
use App\Listeners\Host\CreateHost;
use App\Listeners\Hotel\CreateHotel;
use App\Listeners\Hotel\UpdateEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UpdateHotel::class => [
            UpdateEmail::class,
        ],

        HostRequestedRegistration::class => [

            CreateHost::class,
        ],

        HotelRequestedRegistration::class => [

            CreateHotel::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
