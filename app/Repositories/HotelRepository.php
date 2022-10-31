<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Interfaces\HotelRepositoryInterface;

class HotelRepository implements HotelRepositoryInterface
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
}
