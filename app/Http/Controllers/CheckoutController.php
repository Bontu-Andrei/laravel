<?php

namespace App\Http\Controllers;

use App\Mail\CartInformation;
use App\Order;
use App\OrderProduct;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'contact_details' => 'required',
            'customer_comments' => 'required',
        ]);

        $data = [
            'customer_name' => $request->input('customer_name'),
            'contact_details' => $request->input('contact_details'),
            'customer_comments' => $request->input('customer_comments'),
        ];

        $productsInCart = Product::whereIn('id', session('cart'))->get();

        Mail::to(config('mail.to'))->send(new CartInformation($productsInCart, $data));

        session()->forget('cart');

        //Create order
        $totalPrice = 0;

        foreach ($productsInCart as $product) {
            $totalPrice += $product['price'];
        }

        $order = Order::create([
            'customer_name' => $request->input('customer_name'),
            'customer_details' => $request->input('contact_details'),
            'customer_comments' => $request->input('customer_comments'),
            'product_price_sum' => $totalPrice,
        ]);

        // Create each product for the order
        foreach ($productsInCart as $productInCart) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $productInCart->id,
            ]);
        }

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($data);
        }

        return redirect()->route('cart');
    }
}
