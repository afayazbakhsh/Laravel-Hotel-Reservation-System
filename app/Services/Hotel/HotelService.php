<?php

namespace App\Services\Hotel;

use App\Models\Hotel;
use App\Models\Host;

class HotelService
{
    protected $hotel;

    public function createEmail(Hotel $hotel, $email)
    {
        $hotel->emails()->create([
            'email' => $email,
        ]);
    }

    public function storeHotel(Host $host, array $hotel)
    {
        return $host->hotel()->create([
            'name'      => $hotel['name'],
            'city_id'   => $hotel['city_id'],
        ]);
    }
}
