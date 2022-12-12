<?php

namespace App\Observers;

use App\Models\Host;
use Illuminate\Support\Facades\Cache;

class HostObserver
{
    /**
     * Handle the Host "created" event.
     *
     * @param  \App\Models\Host  $host
     * @return void
     */
    public function created(Host $host)
    {
        Cache::forget('hosts');
    }

    /**
     * Handle the Host "updated" event.
     *
     * @param  \App\Models\Host  $host
     * @return void
     */
    public function updated(Host $host)
    {
        Cache::forget('hosts');
    }

    /**
     * Handle the Host "deleted" event.
     *
     * @param  \App\Models\Host  $host
     * @return void
     */
    public function deleted(Host $host)
    {
        //
    }

    /**
     * Handle the Host "restored" event.
     *
     * @param  \App\Models\Host  $host
     * @return void
     */
    public function restored(Host $host)
    {
        //
    }

    /**
     * Handle the Host "force deleted" event.
     *
     * @param  \App\Models\Host  $host
     * @return void
     */
    public function forceDeleted(Host $host)
    {
        //
    }
}
