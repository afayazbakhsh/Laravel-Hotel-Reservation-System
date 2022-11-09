<?php

namespace Database\Seeders\Rooms;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::create(['type' => 'best1',]);
        RoomType::create(['type' => 'best2',]);
        RoomType::create(['type' => 'best3',]);
    }
}
