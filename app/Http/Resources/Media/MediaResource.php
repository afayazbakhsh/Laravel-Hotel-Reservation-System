<?php

namespace App\Http\Resources\Media;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'file_url' => $this->getTemporaryUrl(Carbon::now()->addMinutes(5)),
        ];
    }
}
