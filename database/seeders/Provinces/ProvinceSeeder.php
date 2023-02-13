<?php

namespace Database\Seeders\Provinces;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Interfaces\ConvertServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProvinceSeeder extends Seeder
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

        if (Storage::disk('public')->exists('excels/province.xlsx')) {

            //convert excels data to array
            $provinces = $this->convertService->ExcelToArray('excels/province.xlsx');

            foreach ($provinces as $data) {

                $province = collect(['name' => $data[0], 'latitude' => $data[2], 'longitude' => $data[3]]);

                Province::create([
                    'name' =>   $this->convertService->ArabicWordToPersian($province['name']),
                    'latitude' =>   $province['latitude'],
                    'longitude' =>   $province['longitude'],
                ]);
            }
        }
    }
}
