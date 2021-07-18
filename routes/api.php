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


Route::namespace('Api')->group(function () {

    // Start Auth
    Route::post('register_new_customer', 'Auth\RegisterController@create');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->middleware('auth:api');
    // End Auth

    //category
    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{category}', 'CategoryController@show');

    //product
    Route::apiResource('products', 'ProductController')->only(['index', 'show']);

    //cart
    Route::get('cart', 'CartController@index')->middleware('auth:api');
    Route::get('cart/store', 'CartController@store')->middleware('auth:api');
    Route::delete('/cart/delete/{product}', 'CartController@delete_product')->middleware('auth:api');
    Route::patch('/cart/{product}', 'CartController@quantity_decrement')->middleware('auth:api');
    Route::post('checkout', 'CartController@checkout')->middleware('auth:api');

    //order
    Route::get('orders', 'OrderController@index')->middleware('auth:api');

    Route::get('wishlist', 'WishlistController@index')->middleware('auth:api');
    Route::post('wishlist', 'WishlistController@store')->middleware('auth:api');
    Route::delete('wishlist/destroy/{id}', 'WishlistController@destroy')->middleware('auth:api');

    //update customer info
    Route::post('customer/update', 'CustomerController@update')->middleware('auth:api');

    //get new arrival products
    Route::get('new_arrival', 'HomeController@new_arrival');

    //get Hot Offers
    Route::get('hot_offers', 'HomeController@hot_offers');



});
