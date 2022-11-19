<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Host;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index(Request $request)
    {
        // get hosts who has a hotel in special city
        return Host::where(function ($query) use ($request){

            if($request->has('national_code')){

                $query->where('national_code',$request->national_code);
            }

        })->whereHas('hotel', function ($query) use ($request) {

                if ($request->has('confirmed')) {

                    $query->confirmed($request->confirmed);
                }

                if ($request->has('city_id')) {

                    $query->where('city_id', $request->city_id);
                }
            })->confirmed()->latest()->get();
    }
}
