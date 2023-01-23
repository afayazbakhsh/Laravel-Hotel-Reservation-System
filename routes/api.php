<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Emails\EmailController;
use App\Http\Controllers\Host\HostController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Registration\HotelRegistrationController;
use App\Http\Controllers\User\UserController;
use App\Models\Hotel;
use App\Models\User;
use App\Services\ImageService;

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
    //Email Routes
    Route::resource('emails',EmailController::class);
    //Hotel Registeration request
    Route::post('hotel-registeration',HotelRegistrationController::class);

    //Protected Route test
    Route::middleware(['auth:sanctum','role:User'])->prefix('tests')->group(function(){
        Route::resource('/',TestController::class);
    });

    // Hotel Routes
    Route::prefix('/')->group(function(){

        Route::get('hotels/',[HotelController::class,'index']);

        Route::post('hosts/{host}/hotels',[HotelController::class,'store']);

        Route::get('hosts/{host}/hotels/{hotel}',[HotelController::class,'show']);

        Route::put('hosts/{host}/hotels/{hotel}',[HotelController::class,'update']);

    });

    Route::get('image',function(){
        $images = [
            'app/demo/aaa1.jpg',
            'app/demo/aaa2.jpg',
            'app/demo/aaa3.jpg'
        ];
        $hotel = Hotel::find(2);
        $service = new ImageService();
        foreach($images as $image){
            $service->compressAndStoreImage($hotel, $image , 'hotel_images_collection');
        }
    });
});
