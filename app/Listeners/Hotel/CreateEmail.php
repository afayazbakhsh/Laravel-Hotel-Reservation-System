<?php

namespace App\Listeners\Hotel;

use App\Events\Hotel\HotelCreated;
use App\Services\Hotel\HotelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class CreateEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $service;

    public function __construct(HotelService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\HotelCreated  $event
     * @return void
     */
    public function handle(HotelCreated $event)
    {

        if ($event->request->emails) {

            foreach ($event->request->emails as $email) {

                // create emails for hotel
                $this->service->createEmail($event->hotel, $email);
            }
        }
    }
}
