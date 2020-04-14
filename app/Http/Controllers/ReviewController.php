<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($reviewableId, $reviewableType)
    {
        $model = null;

        if ($reviewableType == 'product') {
            $model = Product::class;
        } else {
            $model = Order::class;
        }

        if (! $model) {
            return response('Not valid!', 422);
        }

        $item = $model::findOrFail($reviewableId);

        return view('reviews.index', [
            'item' => $item,
            'type' => $reviewableType
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
            $type = Product::class;
        } else {
            $order = Order::find($request->input('reviewable_id'));
            $product = null;
            $type = Order::class;
        }

        if (!$product && !$order) {
            return response('Not find!', 404);
        }

        Review::create([
            'rating' => $request->input('rating'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'reviewable_id' => $request->input('reviewable_id'),
            'reviewable_type' => $type,
        ]);

        return redirect()->back();
    }

    public function destroy($review)
    {
        Review::findOrFail($review)->delete();

        return redirect()->back();
    }
}
