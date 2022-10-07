<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request){

        User::create($request->validated());
        return response('User Registered Succesfully',201);
    }
}
