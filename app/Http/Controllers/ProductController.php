<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $products = Product::latest()->get();
            return ProductResource::collection($products);
        }
        return response()->json(['message' => 'Something went wrong.'], 401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->wantsJson()) {
            $name = $request->name;
            $slug = Str::slug($name, '-');
            $product = Product::create([
                'name' => $request->name,
                'slug' => $slug,
                'code' => $request->code,
                'description' => $request->description,
                'excerpt' => $request->excerpt,
                'unit' => $request->unit,
                'is_active' => $request->is_active,
                'category_ids' => $request->category_ids,
            ]);
            return new ProductResource($product);
        }
        return response()->json(['message' => 'Something went wrong.'], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Product $product)
    {
        if ($request->wantsJson()) {
            return new ProductResource($product);
        }
        return response()->json(['message' => 'Something went wrong.'], 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if ($request->wantsJson()) {
            $name = $request->name;
            $slug = Str::slug($name, '-');
            $product->update([
                'name' => $request->name,
                'slug' => $slug,
                'code' => $request->code,
                'description' => $request->description,
                'excerpt' => $request->excerpt,
                'unit' => $request->unit,
                'is_active' => $request->is_active,
                'category_ids' => $request->category_ids,
            ]);
            return new ProductResource($product);
        }
        return response()->json(['message' => 'Something went wrong.'], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product successfully deleted.'], 200);
    }
}
