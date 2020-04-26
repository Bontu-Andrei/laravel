<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
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

    public function show($orderId, Request $request)
    {
        $order = Order::with(['products'])->findOrFail($orderId);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($order);
        }

        return view('orders.show', [
            'order' => $order,
        ]);
    }
}
