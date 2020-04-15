<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'type' => 'required|in:product,order'
        ]);

        if ($request->query('type') == 'product') {
            $model = Product::class;
        } else {
            $model = Order::class;
        }

        $reviews = $model::findOrFail($request->query('id'))->reviews;

        return view('reviews.index', [
            'reviews' => $reviews,
            'type' => $request->query('type'),
            'id' => $request->query('id')
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

        $review = new Review();
        $review->rating = $request->input('rating');
        $review->title = $request->input('title');
        $review->description = $request->input('description');

        $item = null;

        if ($request->input('reviewable_type') == 'product') {
            $product = Product::find($request->input('reviewable_id'));
            $item = $product;
        } elseif ($request->input('reviewable_type') == 'order') {
            $order = Order::find($request->input('reviewable_id'));
            $item = $order;
        }

        $review->reviewable()->associate($item);
        $review->save();

        return redirect()->back();
    }

    public function destroy($review)
    {
        Review::findOrFail($review)->delete();

        return redirect()->back();
    }
}
