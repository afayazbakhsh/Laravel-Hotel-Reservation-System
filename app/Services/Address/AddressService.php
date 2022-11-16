<?php

namespace App\Services\Address;

use App\Models\Address;
use App\Models\Hotel;

class AddressService
{
    public function storeAddress(Hotel $hotel,array $hotelLocation)
    {
        return $hotel->address()->create([
            'address'       => $hotelLocation['address'],
            'latitude'      => $hotelLocation['latitude'],
            'longitude'     => $hotelLocation['longitude'],
        ]);
    }
}
