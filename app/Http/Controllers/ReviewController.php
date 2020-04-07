<?php

namespace App\Http\Controllers;

use App\Product;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($productId)
    {
        $product =  Product::where('id', $productId)->with(['reviews'])->first();

        return view('reviews.index', [
            'product' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required',
            'description' => 'required',
            'product_id' => 'numeric'
        ]);

        Review::create([
            'rating' => $request->input('rating'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'product_id' => $request->input('product_id')
        ]);

        return redirect()->back();
    }

    public function destroy($review)
    {
        Review::findOrFail($review)->delete();

        return redirect()->back();
    }
}
