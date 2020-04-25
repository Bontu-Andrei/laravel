<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json(Order::all(), 200);
        }

        return view('orders.index', ['orders' => Order::all()]);
    }

    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('orders.show', [
            'order' => $order,
        ]);
    }
}
