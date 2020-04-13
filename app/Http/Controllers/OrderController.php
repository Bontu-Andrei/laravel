<?php

namespace App\Http\Controllers;

use App\Order;

class OrderController extends Controller
{
    public function index()
    {
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
