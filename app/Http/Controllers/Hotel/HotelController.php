<?php

namespace App\Http\Controllers\Hotel;

use App\Events\Hotel\HotelCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Http\Resources\Hotel\HotelCollection;
use App\Http\Resources\Hotel\HotelResource;
use App\Models\Host;
use App\Models\Hotel;
use App\Services\Hotel\HotelService;
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

    // Display hotels
    public function index(Request $request)
    {
        // Get Hotel with children
        $hotels = Hotel::with([
            'host',
            'emails',
            'address',
            'city',
            'phones',
            'images'
        ])->whereNot('name', null)->confirmed();

        // if choose city
        if ($request->has('city_id')) {

            $hotels = $hotels->where('city_id', $request->get('city_id'));
        }

        // Searched text
        if ($request->has('s')) {

            $query = strtolower($request->get('s'));

            $hotels = $hotels->filter(function ($hotel) use ($query) {

                // search in titles
                if (Str::contains(strtolower($hotel->title), $query)) {

                    return true;
                }

                // search in names
                if (Str::contains(strtolower($hotel->name), $query)) {

                    return true;
                }

                return false;
            });
        }

        return response(new HotelCollection($hotels->latest()->paginate(15)), 200);
    }

    /**
     * Create new hotel.
     */
    public function store(Host $host, StoreHotelRequest $request)
    {
        // Create hotel with validated inputs
        $hotel = $host->hotel()->create($request->validated());

        // fire event after hotel created
        event(new HotelCreated($hotel, $request));

        // load emails and host information
        $hotel->load('emails');
        $hotel->load('host');

        return response($hotel, 201);
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

        return response(new HotelResource($hotel), 200);
    }

    /**
     * Update the specified resource.
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
     * Remove the specified resource.
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
