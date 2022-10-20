<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository){

        //object of user repository
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request){

        //check user
        $user = $this->userRepository->getUserByEmail($request->email);
        //check password
        if(!$user || !Hash::check($request->password,$user->password)){
            return response(['message'   =>  'اطلاعات وارد شده اشتباه میباشد'],401);
        }
        //create token
        $token = $user->createToken('auth_token')->plainTextToken;
        return response(['user' => $user,'access_token' => $token], 200);
    }
}
