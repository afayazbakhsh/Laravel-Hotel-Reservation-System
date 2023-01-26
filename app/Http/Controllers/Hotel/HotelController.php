<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Models\Host;
use App\Models\Hotel;
use App\Services\Hotel\HotelService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $hotelService;
    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index(Request $request)
    {
        $hotels = Hotel::with([
            'emails:id,email,emailable_id,emailable_type',
            'address:id,address,addressable_id,addressable_type',
            'city'
        ])->whereNot('name', null)->confirmed()->latest()->get();

        // if choose city
        if ($request->has('city_id')) {

            $hotels = $hotels->where('city_id', $request->get('city_id'));
        }

        // Searched text
        if ($request->has('s')) {

            $query = strtolower($request->get('s'));

            $hotels = $hotels->filter(function ($hotel) use ($query) {

                if (Str::contains(strtolower($hotel->title), $query)) {

                    return true;
                }

                if (Str::contains(strtolower($hotel->name), $query)) {

                    return true;
                }

                return false;
            });
        }
        return response(compact('hotels'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Host $host, StoreHotelRequest $request)
    {
        // Create hotel with validated inputs
        $hotel = $host->hotel()->create($request->validated());

        // Create emails
        if ($request->emails) {

            $this->hotelService->createEmail($hotel, $request->emails);
        }
        $hotel->load('emails');
        $hotel->load('host');
        return response([$hotel], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Host $host, Hotel $hotel)
    {
        $hotel = Hotel::with([
            'emails' => function ($query) {

                $query->orderBy('created_at', 'desc');
            },
            'phones' => function ($query) {

                $query->orderBy('created_at', 'desc');
            },
            'address', 'city'
        ])->find($hotel->id);

        return response([compact(['hotel']), 200]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHotelRequest $request, Host $host, Hotel $hotel)
    {
        $hotel->update($request->validated());
        $hotel->emails;

        return response([compact('hotel')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hotel::findOrFail($id)->delete();
        return response(['message' => 'Deleted successfuly', 200]);
    }


    public function search(Request $request)
    {
        $hotels = Hotel::query();

        if ($request->has('name')) {

            $hotels->where('name', '%like', $request->name);
        }

        if ($request->has('city_id')) {

            $hotels->where('city_id', $request->city_id);
        }
    }
}
