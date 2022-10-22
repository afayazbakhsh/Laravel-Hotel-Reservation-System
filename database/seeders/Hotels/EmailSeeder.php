<?php

namespace Database\Seeders\Hotels;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
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

            $hotel->emails()->createMany([

                ['email' => 'amirtest1@gmail.com'],
                ['email' => 'amirtest2@gmail.com'],
            ]);
        }
    }
}
