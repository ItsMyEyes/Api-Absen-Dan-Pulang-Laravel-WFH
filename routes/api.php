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
Route::get('/',function(){
    return response()->json([
        'message' => 'success connected',
        'code' => 200
    ],200);
});
Route::post('/absen/masuk','AbsenController@store');
Route::post('/absen/pulang','AbsenController@update');
