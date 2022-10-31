<?php
namespace App\Interfaces;

use App\Models\Hotel;

interface HotelRepositoryInterface
{
    public function createEmail(Hotel $hotel, $emails);
}
