<?php

namespace App\Listeners\Hotel;

use App\Events\Hotel\HotelCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UploadImage
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
     * @param  \App\Events\HotelCreated  $event
     * @return void
     */
    public function handle(HotelCreated $event)
    {
        if ($event->request->images) {

            foreach ($event->request->images as $image) {

                // upload image in s3 disk and store in database
                $event->hotel->addMedia($image)->toMediaCollection('hotel-images', 's3');
            }
        }
    }
}
