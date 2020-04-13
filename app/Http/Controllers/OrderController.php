<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index', ['orders' => Order::all()]);
    }

    public function show($orderId)
    {
        $order = Order::where('id', $orderId)->with(['products'])->firstOrFail();

        return view('orders.show', [
            'order' => $order
        ]);
    }
}
