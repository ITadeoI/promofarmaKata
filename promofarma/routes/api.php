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

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'AuthController@login')->name('login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
    });

});

Route::apiResource('/products', 'ProductController');

Route::group(['prefix'=>'products'], function() {
    Route::apiResource('/{product}/reviews', 'ReviewController');
});

Route::apiResource('carts', 'CartController')->except(['update', 'index']);
Route::post('/carts/{cart}', 'CartController@addProducts');
Route::post('/carts/{cart}/checkout', 'CartController@checkout');