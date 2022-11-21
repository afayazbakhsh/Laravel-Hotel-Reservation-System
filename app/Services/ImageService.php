<?php

namespace App\Services;

use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    public function compressAndStoreImage($model, $image ,$collectionName)
    {
        $model->addMedia(storage_path($image))->toMediaCollection($collectionName,'s3');
    }
}
