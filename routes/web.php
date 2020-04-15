<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', 'IndexController@index')->name('index');

Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart/{productId}', 'CartProductController@store')->name('cart.store');
Route::delete('/cart/{productId}', 'CartProductController@destroy')->name('cart.destroy');

Route::post('/checkout', 'CheckoutController@store')->name('checkout');

Route::get('/reviews', 'ReviewController@index')->name('reviews');
Route::post('/reviews', 'ReviewController@store')->name('reviews.create');

Route::get('/javascript', function () {
    return view('javascript');
});

Route::middleware(['admin'])->group(function () {
    Route::resource('products', 'ProductController')->except('show');

    Route::get('/orders', 'OrderController@index')->name('orders');
    Route::get('/order/{orderId}', 'OrderController@show')->name('orders.show');

    Route::delete('/review/{review}', 'ReviewController@destroy')->name('review.destroy');
});


