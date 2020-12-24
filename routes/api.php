<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather',function (){
    $apiOwmKey = config('services.owm.key');
    $lat = request('lat');
    $lng = request('lng');
 $response = Http::get("https://api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$lng&units=metric&appid=$apiOwmKey");
 return $response->json();
});


Route::get('/venue',function (){
    $lat = request('lat');
    $lng = request('lng');
    $client_id = config('services.foursquare.key');
    $secret_id = config('services.foursquare.secretkey');
    // $response = Http::get("https://api.foursquare.com/v2/venues/search?ll=$lat,$lng");
    $response = Http::get("https://api.foursquare.com/v2/venues/explore?client_id=$client_id&client_secret=$secret_id&v=20180323&limit=5&ll=$lat,$lng");
 return $response->json();
});