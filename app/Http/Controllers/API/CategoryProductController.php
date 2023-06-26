<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Validator;

class CategoryProductController extends Controller
{
    public function index()
    {
        $categories = CategoryProduct::all();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_category_product' => 'required|string',
        ]);

        $category = CategoryProduct::create($validatedData);

        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = CategoryProduct::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_category_product' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $category = CategoryProduct::find($id);
    
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    
        $category->update($request->all());
    
        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = CategoryProduct::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
