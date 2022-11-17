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
Route::post('/login', 'LoginController@login');
Route::group(['middleware' => ['cors', 'json.response','auth:api']], function () {
    Route::post("lowest_post_integer",'PartoneController@low_int_post');
    Route::get("DonotFive",'PartoneController@DonotFive');
    Route::get("alphaIndex",'PartoneController@alphaIndex');

    Route::post('new_order','orderController@create_order');
});


