<?php

namespace App\Http\Resources\Hotel;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\Email\EmailResource;
use App\Http\Resources\HostResource;
use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'motto' => $this->moto,
            'is_confirm' => $this->is_confirm,
            'city'  => new CityResource($this->whenLoaded('city')),
            'address'  => new AddressResource($this->whenLoaded('address')),
            'emails'  => EmailResource::collection($this->whenLoaded('emails')),
            'host'  => new HostResource($this->whenLoaded('host')),
            'images'  => MediaResource::collection($this->whenLoaded('images')),
        ];
    }
}
