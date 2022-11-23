<?php

namespace App\Jobs\Hotel;

use App\Services\Address\AddressService;
use App\Services\Host\HostService;
use App\Services\Hotel\HotelService;
use App\Services\ImageService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HotelRegistration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(HostService $hostService, HotelService $hotelService, AddressService $addressService, ImageService $compressImageService)
    {
        // Requester data
        $requesterInfo = collect([
            'first_name'    => $this->request['requester_info']['first_name'],
            'last_name'     => $this->request['requester_info']['last_name'],
            'national_code' => $this->request['requester_info']['national_code'],
            'phone_number'  => $this->request['requester_info']['phone_number'],
            'email'         => $this->request['requester_info']['email']
        ])->toArray();

        // Hotel data
        $requestedHotel = collect([
            'name'          => $this->request['hotel']['name'],
            'city_id'       => $this->request['hotel']['city_id']
        ])->toArray();

        // Address data
        $requestedHotelLocation = collect([
            'address'       => $this->request['hotel']['hotel_location'][0]['address'],
            'latitude'      => $this->request['hotel']['hotel_location'][0]['latitude'],
            'longitude'     => $this->request['hotel']['hotel_location'][0]['longitude']
        ])->toArray();


        try {
            DB::beginTransaction();
            //try to save requester information as host
            $host = $hostService->storeHost($requesterInfo);
            //try to save requested hotel details
            $hotel = $hotelService->storeHotel($host, $requestedHotel);
            //try to save requested hotel address
            $address = $addressService->storeAddress($hotel, $requestedHotelLocation);
            //compress images one by one
            // if ($this->request['sample_images']) {
            //     foreach ($this->request['sample_images'] as $image) {
            //         Log::info($image);
            //         // try to commpress images
            //         $commpressImage = $compressImageService->compress($image);
            //     }
            // }

            DB::commit();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], 500);
        } catch (\Error $error) {
            Log::error($error->getMessage());
            DB::rollBack();
            return $error->getMessage();
        }
    }

    // public function failed(Exception $exception)
    // {
    //     Log::info($exception->getMessage());
    //     return $exception->getMessage();
    // }
}
