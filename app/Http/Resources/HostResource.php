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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'hotel' => new HotelResource($this->whenLoaded('hotel')),
        ];
    }
}
