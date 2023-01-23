<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {

        $user = User::create($request->validated());
        // See permissionSeeder for user permissions
        $user->assignRole('user');
        // Create access token
        $token = $user->createToken('auth_token')->plainTextToken;
        return response(['user' => $user, 'access_token' => $token], 200);
    }
}
