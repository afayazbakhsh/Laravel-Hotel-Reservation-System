<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\RoomType;
use Database\Seeders\Cities\CitySeeder;
use Database\Seeders\Hosts\HostSeeder;
use Database\Seeders\Hotels\AddressSeeder;
use Database\Seeders\Hotels\EmailSeeder;
use Database\Seeders\Hotels\HotelSeeder;
use Database\Seeders\Hotels\PhoneSeeder;
use Database\Seeders\Provinces\ProvinceSeeder;
use Database\Seeders\Rooms\RoomTypeSeeder;
use Database\Seeders\Users\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        return $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            RoomTypeSeeder::class,
            HostSeeder::class,
        ]);
    }
}
