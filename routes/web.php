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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', 'IndexController@index')->name('index');

Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart/{productId}', 'CartProductController@store')->name('cart.store');
Route::delete('/cart/{productId}', 'CartProductController@destroy')->name('cart.destroy');

Route::post('/checkout', 'CheckoutController@store')->name('checkout');

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login', 'LoginController@store')->name('login.store');
Route::delete('/logout', 'LoginController@destroy')->name('logout');


