<?php

namespace Database\Seeders\Cities;

use App\Interfaces\ConvertServiceInterface;
use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $convertService;

    public function __construct(ConvertServiceInterface $service)
    {
        $this->convertService = $service;
    }

    public function run()
    {
        if (Storage::disk('public')->exists('excels/city.xlsx')) {

            //convert excels data to array
            $cities = $this->convertService->ExcelToArray('excels/city.xlsx');

            foreach ($cities as $data) {

                $city = collect(['name' => $data[1], 'provinceName' => $data[0], 'latitude' => $data[4], 'longitude' => $data[5]]);

                //convert arabic to persian
                $provinceName = $this->convertService->ArabicWordToPersian($city['provinceName']);
                //get province of each city from databse
                $province = Province::where('name', $provinceName)->first();

                City::create([
                    'name' =>   $this->convertService->ArabicWordToPersian($city['name']),
                    'province_id'  => $province->id,
                    'latitude' =>   $city['latitude'],
                    'longitude' =>   $city['longitude'],
                ]);
            }
        }
    }
}
