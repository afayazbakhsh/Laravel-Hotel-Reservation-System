<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;

class CompressImageService
{

    public function compress($path)
    {
        Image::configure(['driver' => 'imagick']);

        // check image if exist
        if (!File::exists($path)) {

            Log::info('dont exist');
        }
        // get file to use
        $image = File::get($path);
        $compressedImage = Image::make($image)->response();
        // ->save($name,60);

    }
}
