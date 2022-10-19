<?php

namespace App\Classes\Excels;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Support\Facades\Storage;

class Convert
{

    public static function convertToArray($filePath)
    {
        $reader = new Xlsx();
        $data = $reader->load(Storage::path('public/' . $filePath));
        return $data->getActiveSheet()->toArray();
    }
}
