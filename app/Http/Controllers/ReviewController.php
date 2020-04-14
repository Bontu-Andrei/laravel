<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        request()->validate([
            'id' => 'required|numeric',
            'type' => 'required|in:product,order'
        ]);

        if (request()->query('type') == 'product') {
            $model = Product::class;
        } else {
            $model = Order::class;
        }

        $item = $model::findOrFail(request()->query('id'));

        return view('reviews.index', [
            'item' => $item,
            'type' => request()->query('type')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required',
            'description' => 'required',
            'reviewable_id' => 'required|numeric',
            'reviewable_type' => 'required|in:product,order'
        ]);

        if ($request->input('reviewable_type') == 'product') {
            $product = Product::find($request->input('reviewable_id'));
            $order = null;
            $product->reviews()->create([
                'rating' => $request->input('rating'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);
        } elseif ($request->input('reviewable_type') == 'order') {
            $order = Order::find($request->input('reviewable_id'));
            $product = null;
            $order->reviews()->create([
                'rating' => $request->input('rating'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);
        }

        if (!$product && !$order) {
            return response('Not find!', 404);
        }

        return redirect()->back();
    }

    public function destroy($review)
    {
        Review::findOrFail($review)->delete();

        return redirect()->back();
    }
}
