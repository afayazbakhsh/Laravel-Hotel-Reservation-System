<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Cities\CitySeeder;
use Database\Seeders\Hotels\AddressSeeder;
use Database\Seeders\Hotels\EmailSeeder;
use Database\Seeders\Hotels\HotelSeeder;
use Database\Seeders\Hotels\PhoneSeeder;
use Database\Seeders\Provinces\ProvinceSeeder;
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
            UserSeeder::class,
            PermissionSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            HotelSeeder::class,
            EmailSeeder::class,
            PhoneSeeder::class,
            AddressSeeder::class,
        ]);
    }
}
