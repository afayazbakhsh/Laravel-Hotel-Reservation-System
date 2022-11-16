<?php

namespace App\Services\Hotel;

use App\Models\Hotel;
use App\Models\Host;

class HotelService
{
    protected $hotel;

    public function __construct(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }

    public function createEmail(Hotel $hotel, $emails)
    {
        foreach ($emails as $email) {
            $hotel->emails()->create([
                'email' => $email,
            ]);
        }
    }

    public function createHotel(Host $host, array $hotel)
    {
        return $host->hotel()->create([
            'name'      => $hotel['name'],
            'city_id'   => $hotel['city_id'],
        ]);
    }
}
