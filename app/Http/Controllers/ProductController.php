<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\UserGallery;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $user = Auth::user();
        $images = UserGallery::where('user_id', $user->id)->get();

        return view('products.create', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10|max:1000',
            'main_image' => 'required',
            'variants' => [
                'required',
                'json',
                function ($attribute, $value, $fail) {
                    $variants = json_decode($value, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        return $fail('The variants field must be a valid JSON.');
                    }
                    foreach ($variants as $variant) {
                        if (!isset($variant['name']) || !is_string($variant['name'])) {
                            return $fail('Each variant must have a valid name.');
                        }
                        if (!isset($variant['values']) || !is_array($variant['values'])) {
                            return $fail('Each variant must have a valid array of values.');
                        }
                    }
                }
            ],
        ]);

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'main_image' =>  $request->main_image,
            'variants' => json_decode($request->variants),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $user = Auth::user();
        $images = UserGallery::where('user_id', $user->id)->get();

        return view('products.edit', compact('product', 'images'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10|max:1000',
            'main_image' => 'required',
            'variants' => [
                'required',
                'json',
                function ($attribute, $value, $fail) {
                    $variants = json_decode($value, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        return $fail('The variants field must be a valid JSON.');
                    }
                    foreach ($variants as $variant) {
                        if (!isset($variant['name']) || !is_string($variant['name'])) {
                            return $fail('Each variant must have a valid name.');
                        }
                        if (!isset($variant['values']) || !is_array($variant['values'])) {
                            return $fail('Each variant must have a valid array of values.');
                        }
                    }
                }
            ],
        ]);
    
        $product->title = $request->title;
        $product->description = $request->description;
        $product->main_image = $request->main_image;
        $product->variants = json_decode($request->variants);
        $product->save();
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function uploadToGallery(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $user = Auth::user(); 

        if ($request->file('image')->isValid()) {
            $imagePath = $request->file('image')->move(public_path('images'), $request->file('image')->getClientOriginalName());
            $imageUrl = '/images/' . $request->file('image')->getClientOriginalName(); 
            $userGallery = new UserGallery();
            $userGallery->user_id = $user->id;
            $userGallery->image_path = $imageUrl;
            $userGallery->save();

            return response()->json(['image_url' => $imageUrl]);
        }

        return response()->json(['error' => 'Invalid file.']);
    }
}
