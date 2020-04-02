<?php

namespace App\Http\Controllers;

use App\Product;

class CartProductController extends Controller
{
    public function store($productId)
    {
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        $cart[] = $product->id;

        session()->put('cart', $cart);

        return redirect()->route('index');
    }

    public function destroy($productId)
    {
        // Remove product from cart session
        $cart = session()->get('cart', []);

        $index = array_search((int) $productId, $cart);

        if ($index >= 0) {
            unset($cart[$index]);

            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}
