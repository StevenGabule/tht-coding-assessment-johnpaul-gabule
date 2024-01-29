<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $categories = Category::latest()->get();
            return CategoryResource::collection($categories);
        }
        return response()->json(['message' => 'Something went wrong.'], 401);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->wantsJson()) {
            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => $request->is_active,
            ]);
            return new CategoryResource($category);
        }
        return response()->json(['message' => 'Something went wrong.'], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category)
    {
        if ($request->wantsJson()) {
            return new CategoryResource($category);
        }
        return response()->json(['message' => 'Something went wrong.'], 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if ($request->wantsJson()) {
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => $request->is_active,
            ]);
            return new CategoryResource($category);
        }
        return response()->json(['message' => 'Something went wrong.'], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category successfully deleted.'], 200);
    }
}
