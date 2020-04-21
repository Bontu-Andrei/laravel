<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $ids = [];

        if (session()->has('cart')) {
            $ids = session('cart');
        }

        $productsInCart = Product::whereIn('id', $ids)->get();

        if ($request->wantsJson()) {
            return response()->json($productsInCart);
        }

        return view('cart', ['products' => $productsInCart]);
    }
}
