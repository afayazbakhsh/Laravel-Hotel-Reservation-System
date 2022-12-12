<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Resources\HostCollection;
use App\Http\Resources\HostResource;
use App\Models\Host;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HostController extends Controller
{
    public function index(Request $request)
    {
        // get hosts who has a hotel
        $hosts = Cache::remember('hosts', 60 * 60, function () use ($request) {

            return Host::where(function ($query) use ($request) {

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
        });
        return HostResource::collection($hosts);
    }
}
