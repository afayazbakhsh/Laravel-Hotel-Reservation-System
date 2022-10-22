<?php

namespace Database\Seeders\Hotels;

use App\Models\Address;
use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {

            $hotel->address()->create([

                'address' => 'test address',
                'latitude' => rand(1000, 100000),
                'longitude' => rand(1000, 100000),
            ]);
        }
    }
}
