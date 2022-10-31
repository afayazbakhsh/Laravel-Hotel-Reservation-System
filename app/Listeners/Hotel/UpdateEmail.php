<?php

namespace App\Listeners\Hotel;

use App\Events\Hotel\UpdateHotel;
use App\Models\Email;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UpdateHotel  $event
     * @return void
     */
    public function handle(UpdateHotel $event)
    {
        foreach ($event->emails as $email) {
            Log::info($email);
            Email::where('emailable_id',$event->hotel->id)->where('email',$email)->update([
                'email'=> $email,
            ]);
        }
    }
}
