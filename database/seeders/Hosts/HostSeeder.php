<?php

namespace Database\Seeders\Hosts;

use App\Models\Address;
use App\Models\Email;
use App\Models\Host;
use App\Models\Hotel;
use App\Models\Phone;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $types = RoomType::all();
        // Create host factory with hotel
        return Host::factory()->times(5)->create()->each(function ($host) {

            // Create hotel with child entity
            Hotel::factory(3)->create([

                'host_id' => $host->id,

            ])->each(function ($hotel){

                Address::factory(1)->create([
                    'addressable_id' => $hotel->id,
                    'addressable_type' => 'App\Models\Hotel'
                ]);

                Email::factory(2)->create([
                    'emailable_id' => $hotel->id,
                    'emailable_type' => 'App\Models\Hotel'
                ]);

                Phone::factory(2)->create([
                    'phoneable_id' => $hotel->id,
                    'phoneable_type' => 'App\Models\Hotel'
                ]);

                Room::factory(rand(1,4))->create([
                    'hotel_id' => $hotel->id,
                    'room_type_id' => RoomType::all()->random()->id
                ]);
            });
        });
    }
}
