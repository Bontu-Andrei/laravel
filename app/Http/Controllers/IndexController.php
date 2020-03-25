<?php

namespace App\Http\Controllers;

use App\Product;

class IndexController extends Controller
{
    public function index()
    {
        $ids = [];

        if (session()->has('cart')) {
            $ids = session()->get('cart');
        }

        $productsNotInCart = Product::whereNotIn('id', $ids)->get();

        return view('index', ['products' => $productsNotInCart]);
    }
}
