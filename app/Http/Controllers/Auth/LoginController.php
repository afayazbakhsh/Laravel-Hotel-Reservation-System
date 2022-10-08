<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request){

        //check email
        $user = User::where('email',$request->email)->first();
        //check password
        if(!$user || !Hash::check($request->password,$user->password)){
            return response(['message'   =>  'اطلاعات وارد شده اشتباه میباشد',],401);
        }
        //create token
        $token = $user->createToken('user_token')->plainTextToken;
        return response(['user' => $user,'token' => $token], 200);
    }
}
