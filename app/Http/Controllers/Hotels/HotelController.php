<?php

namespace App\Http\Controllers\Hotels;

use App\Events\Hotel\UpdateHotel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Http\Requests\Hotel\UpdateHotelRequest;
use App\Interfaces\HotelRepositoryInterface;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $HotelRepository;
    public function __construct(HotelRepositoryInterface $HotelRepository)
    {
        $this->HotelRepository = $HotelRepository;
    }

    public function index()
    {
        return Hotel::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHotelRequest $request)
    {
        $hotel = Hotel::create($request->validated());

        if ($request->emails) {
            $this->HotelRepository->createEmail($hotel, $request->emails);
        }
        $hotel->emails;
        return response(compact('hotel'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel = Hotel::with([
            'emails' => function ($query) {

                $query->orderBy('created_at', 'desc');

            }, 'phones' => function ($query) {

                $query->orderBy('created_at', 'desc');

            }, 'address', 'city'])->find($id);

        return response([compact(['hotel']), 200]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHotelRequest $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
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

        if ($request->get('name')) {

            $hotels->where('name', '%like', $request->name);
        }

        if ($request->get('city_id')) {

            $hotels->where('city_id', $request->city_id);
        }
    }
}
