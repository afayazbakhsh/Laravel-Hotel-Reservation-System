<?php

use App\Admin\Controllers\HostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Hotel\HotelController;

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

Route::prefix('v1')->group(function () {

    //Auth Route
    Route::prefix('auth')->group(function () {
        //Register
        Route::post('register', [RegisterController::class, 'register']);
        //Login
        Route::post('login', [LoginController::class, 'login']);
        //Logout
        Route::middleware('auth:sanctum')->get('logout', [LogoutController::class, 'logout']);
    });

    Route::middleware(['auth:sanctum', 'abilities:hotel-view,hotel-create'])->group(function () {

        Route::apiResource('hotels', HotelController::class);
    });
    Route::apiResource('hosts', HostController::class);
});
