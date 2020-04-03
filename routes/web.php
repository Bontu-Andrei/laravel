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

Route::middleware(['admin'])->group(function () {
    Route::get('/products', 'ProductController@index')->name('products');

    Route::get('/product/create', 'ProductController@create')->name('product.create');
    Route::post('/product/create', 'ProductController@store')->name('product.store');
    Route::get('/products/edit/{product}', 'ProductController@edit')->name('product.edit');
    Route::put('/products/update/{product}', 'ProductController@update')->name('product.update');
});


