<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request){

        $user = User::create($request->validated());
        $token = $user->createToken('user_token')->plainTextToken;
        return response(['user' => $user, 'token' => $token],201);
    }
}
