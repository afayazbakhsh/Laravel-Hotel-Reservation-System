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
use App\Models\User;
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

    public function __construct(public HotelService $hotelService)
    {
    }


    /**
     * search hotels
     **/
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
        ])->whereNot('name', null)->confirmed(false);

        // If choose city
        if ($request->has('city')) {

            $hotels = $hotels->where('city_id', $request->get('city'));
        }

        $hotels = $hotels->get();

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

        if ($hotels->isEmpty()) {

            return response(['message' => 'Not found any result'], 404);
        }

        return response(new HotelCollection($hotels), 200);
    }

    /**
     * If we want use scout for search
     **/

    // public function index(Request $request)
    // {
    //     if ($request->has('s')) {

    //         $hotels =  Hotel::search($request->get('s'))->get();
    //     } else {
    //         $hotels = Hotel::all();
    //     }

    //     return response(new hotelCollection($hotels));
    // }

    /**
     * Create new hotel.
     **/
    public function store(StoreHotelRequest $request)
    {
        // Create hotel after validated inputs
        $hotel = Hotel::create($request->validated() + [
            'slug' => Str::slug($request->name),
        ]);

        // Fire event after hotel created
        event(new HotelCreated($hotel, $request));

        // Load informations
        $hotel->load('emails');
        $hotel->load('host');
        $hotel->load('images');
        $hotel->load('city');

        return response(new HotelResource($hotel), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        $hotel->load([
            'emails' => function ($query) {

                $query->orderBy('created_at', 'desc');
            },
            'phones' => function ($query) {

                $query->orderBy('created_at', 'desc');
            },
            'address', 'city'
        ]);

        return response(new HotelResource($hotel), 200);
    }

    /**
     * Update the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
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
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
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
