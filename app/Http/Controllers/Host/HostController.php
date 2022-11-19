<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Host;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index()
    {

        return Host::confirmed()->with(['hotel'])->get();
    }
}
