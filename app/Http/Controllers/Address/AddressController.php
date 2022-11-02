<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Model $hotel, Request $request)
    {

        if (!$hotel->address) {
            $address = $hotel->address()->create([
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            return response([compact('address'), 201]);
        }
            return response(['Address is aviable']);
    }
}
