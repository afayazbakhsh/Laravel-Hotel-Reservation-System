<?php

namespace Database\Seeders\Provinces;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use App\Models\Province;
use App\Classes\Excels\Convert;
use Illuminate\Support\Facades\Storage;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (Storage::disk('public')->exists('excels/province.xlsx')) {

            //convert excels data to array
            $provinces = Convert::convertToArray('excels/province.xlsx');

            foreach ($provinces as $data) {

                $province = collect(['name' => $data[0], 'latitude' => $data[2], 'longitude' => $data[3]]);

                Province::create([
                    'name' =>   $province['name'],
                    'latitude' =>   $province['latitude'],
                    'longitude' =>   $province['longitude'],
                ]);
            }
        }
    }
}
