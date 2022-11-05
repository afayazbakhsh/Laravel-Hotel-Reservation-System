<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use App\Models\Host;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index(){

        return Host::where('is_confirm',false)->with('hotel')->get();
    }
}
