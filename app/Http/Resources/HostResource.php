<?php

namespace App\Http\Resources;

use App\Http\Resources\Hotel\HotelCollection;
use App\Http\Resources\Hotel\HotelResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HostResource extends JsonResource
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
            'national_code' => $this->national_code,
            'phone_number' => $this->phone_number,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'hotel' => new HotelResource($this->whenLoaded('hotel')),
        ];
    }
}
