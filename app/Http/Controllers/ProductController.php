<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json(Product::all(), 200);
        }

        return view('products.index', ['products' => Product::all()]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:1000',
        ]);

        Product::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image_path' => $request->file('image_path')->store('images', 'public'),
        ]);

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image_path' => 'image|mimes:jpeg,png,jpg|max:1000',
        ]);

        if ($request->hasFile('image_path')) {
            if ($product->image_path != '/images/default.jpg') {
                //Delete old image
                Storage::disk('public')->delete($product->image_path);
            }

            $imagePath = $request->file('image_path')->store('images', 'public');
        } else {
            $imagePath = $product->image_path;
        }

        $product->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image_path' => $imagePath,
        ]);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($product->fresh(), 200);
        }

        return redirect()->route('products.index');
    }

    public function destroy($product, Request $request)
    {
        Product::findOrFail($product)->delete();

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([]);
        }

        return redirect()->back();
    }
}
