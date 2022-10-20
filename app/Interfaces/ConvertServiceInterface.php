<?php

namespace App\Interfaces;

interface ConvertServiceInterface
{
    public function ExcelToArray(string $filePath): array;
    public function ArabicWordToPersian(string $word);
}
