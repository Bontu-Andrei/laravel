<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $ids = [];

        if (session()->has('cart')) {
            $ids = session()->get('cart');
        }

        $productsNotInCart = Product::whereNotIn('id', $ids)->get();

        if ($request->wantsJson()) {
            return response()->json($productsNotInCart);
        }

        return view('index', ['products' => $productsNotInCart]);
    }
}
