<?php

namespace App\Services;

use App\Interfaces\ConvertServiceInterface;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Support\Facades\Storage;

class ConvertService implements ConvertServiceInterface
{
    //****** this service contains all method for converting ******//

    //convert excel data to array
    public function ExcelToArray(string $filePath): array
    {
        $reader = new Xlsx();
        $data = $reader->load(storage_path('app/public') . '/' . $filePath);
        return $data->getActiveSheet()->toArray();
    }

    //convert arabic words to persion
    public function ArabicWordToPersian($string)
    {
        $string = trim($string);

        $arabic_letters = ['ي', 'ك', 'ؤ', 'ۀ'];

        $persian_letters = ['ی', 'ک', 'و', 'ه'];

        return str_replace($arabic_letters, $persian_letters, $string);
    }
}
