<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Host\HostController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Registration\HotelRegistrationController;
use App\Http\Controllers\User\UserController;

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

    //User Routes
    Route::resource('users', UserController::class);
    //Host Routes
    Route::resource('hosts', HostController::class);
    //Hotel Registeration request
    Route::post('hotel-registeration', HotelRegistrationController::class);

    // Hotel Routes
    Route::prefix('/')->group(function () {

        Route::get('hotels/', [HotelController::class, 'index']);

        Route::post('hosts/{host}/hotels', [HotelController::class, 'store']);

        Route::get('hosts/{host}/hotels/{hotel}', [HotelController::class, 'show']);

        Route::put('hosts/{host}/hotels/{hotel}', [HotelController::class, 'update']);
    });
});
