<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $ids = [];

        if (session()->has('cart')) {
            $ids = session('cart');
        }

        $productsInCart = Product::whereIn('id', $ids)->get();

        return view('cart', ['products' => $productsInCart]);
    }
}
