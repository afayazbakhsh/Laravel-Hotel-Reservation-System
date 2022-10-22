<?php

namespace Database\Seeders\Hotels;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
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

            $hotel->phones()->createMany([

                ['number' => '09111111111'],
                ['number' => '09222222222'],
            ]);
        }
    }
}
