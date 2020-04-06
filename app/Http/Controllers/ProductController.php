<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', ['products' => Product::all()]);
    }

    public function create(Product $product)
    {
        $action = 'create';

        return view('products.create', [
            'product' => $product,
            'action' => $action
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:1000',
        ]);

        if ($request->hasFile('image_path')) {
            $storagePath = $request->file('image_path')->store('images', 'public');

            $imagePath = str_replace('images/', '', $storagePath);
        }

        Product::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('products');
    }

    public function edit(Product $product)
    {
        $action = 'edit';

        return view('products.edit', [
            'product' => $product,
            'action' => $action
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
            //Delete old image
            Storage::disk('public')->delete('images/'.$product->image_path);

            $storagePath = $request->file('image_path')->store('images', 'public');

            $imagePath = str_replace('images/', '', $storagePath);
        } else {
            $imagePath = $product->image_path;
        }

        $product->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('products');
    }

    public function destroy($productId)
    {
        Product::findOrFail($productId)->delete();

        return redirect()->back();
    }
}
