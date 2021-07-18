<?php

use Illuminate\Support\Facades\Route;

Route::view('/de','dashboard.offers.index');
Route::post('/save',function (){
    dd(request()->all());
})->name('save');

Auth::routes(['register' => false]);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('categories', 'CategoryController')->except(['show']);
    Route::resource('products', 'ProductController');

    Route::get('customers', 'CustomerController@index')->name('customers.index');
    Route::delete('customers', 'CustomerController@index')->name('customers.destroy');

    //order routes
    Route::resource('orders', 'OrderController');
    Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');
    Route::get('/orders/{order}/show', 'OrderController@show_status')->name('orders.show_status');
    Route::put('/orders/{order}/update', 'OrderController@update_status')->name('orders.update_status');

});
