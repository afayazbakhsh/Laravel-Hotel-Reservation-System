<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request){

        $user = User::create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;
        $role = Role::create(['name' => 'viewer']);
        return response(['user' => $user, 'user_role' => $role, 'access_token' => $token],201);
    }
}
