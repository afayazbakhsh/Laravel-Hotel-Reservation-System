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
        $i = 0;
        foreach ($hotels as $hotel) {

            $hotel->emails()->createMany([

                ['email' => 'amirtestr'.$i++.'@gmail.com'],
                ['email' => 'amirtest'.$i.'@gmail.com'],
            ]);
        }
    }
}
