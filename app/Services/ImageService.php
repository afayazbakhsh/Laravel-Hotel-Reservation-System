<?php

namespace App\Services;

class ImageService
{

    public function compressAndStoreImage($model, $image ,$collectionName)
    {
        $model->addMedia(storage_path($image))->toMediaCollection($collectionName,'s3');
    }
}
