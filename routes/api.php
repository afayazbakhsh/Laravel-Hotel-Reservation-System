<?php

use App\Http\Controllers\Address\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Emails\EmailController;
use App\Http\Controllers\Hosts\HostController;
use App\Http\Controllers\Hotels\HotelController;
use App\Http\Controllers\Users\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){

    //Auth Route
    Route::prefix('auth')->group(function(){
        //Register
        Route::post('register',[RegisterController::class,'register']);
        //Login
        Route::post('login',[LoginController::class,'login']);
        //Logout
        Route::middleware('auth:sanctum')->get('logout',[LogoutController::class,'logout']);
    });

    //User Routes
    Route::resource('users',UserController::class);
    //Host Routes
    Route::resource('hosts',HostController::class);
    //Hotel Routes
    Route::resource('hotels',HotelController::class);
    //Email Routes
    Route::resource('emails',EmailController::class);

    //Protected Route test
    Route::middleware(['auth:sanctum','role:User'])->prefix('tests')->group(function(){
        Route::resource('/',TestController::class);
    });
});
