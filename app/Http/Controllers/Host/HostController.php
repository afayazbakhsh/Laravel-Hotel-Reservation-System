<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Resources\HostResource;
use App\Models\Host;
use Illuminate\Http\Request;

class HostController extends Controller
{

    /**
     * Create a user
     *
     * [Insert optional longer description of the API endpoint here.]
     *
     */
    public function index(Request $request)
    {
        // get hosts who has a hotel
        $hosts = Host::where(function ($query) use ($request) {
            // Get data with national code
            $query->when(request('national_code'), function ($query) use ($request) {

                $query->where('national_code', $request->national_code);
            });
        })->whereHas('hotel', function ($query) use ($request) {

            if ($request->has('confirmed')) {

                $query->confirmed($request->confirmed);
            }

            if ($request->has('city_id')) {

                $query->where('city_id', $request->city_id);
            }
        })->with('hotel.city', 'hotel.address')->confirmed()->latest()->get();

        return HostResource::collection($hosts);
    }
}
