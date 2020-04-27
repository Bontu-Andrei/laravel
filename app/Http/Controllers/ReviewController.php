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

        $type = $request->query('type') === 'product' ? Product::class : Order::class;

        $reviews = Review::where('reviewable_id', $request->query('id'))->where('reviewable_type', $type)->get();

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($reviews);
        }

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

        $review = new Review([
            'rating' => $request->input('rating'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        if ($request->input('reviewable_type') == 'product') {
            $item = Product::find($request->input('reviewable_id'));
        } else {
            $item = Order::find($request->input('reviewable_id'));
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
