<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Jobs\Hotel\HotelRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HotelRegistrationController extends Controller
{
    public function __invoke(Request $request)
    {
        // Some step to store hotel information in job
        HotelRegistration::dispatch($request->all());
    }
}
