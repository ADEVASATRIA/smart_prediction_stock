<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class CategoryProductController extends Controller
{
    public function __construct()
    {
        // Terapkan middleware jwt.auth pada semua metode kecuali index dan show
        $this->middleware('jwt.auth')->except(['index', 'show']);
    }

    public function index()
    {
        $categories = CategoryProduct::all();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::getToken();

        try {
            // Memeriksa validitas token dan peran pengguna
            $user = JWTAuth::toUser($token);
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // Jika token tidak valid, kembalikan respon error
            return response()->json(['message' => 'Invalid token'], 401);
        }

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
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::getToken();

        try {
            // Memeriksa validitas token dan peran pengguna
            $user = JWTAuth::toUser($token);
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // Jika token tidak valid, kembalikan respon error
            return response()->json(['message' => 'Invalid token'], 401);
        }

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
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::getToken();

        try {
            // Memeriksa validitas token dan peran pengguna
            $user = JWTAuth::toUser($token);
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // Jika token tidak valid, kembalikan respon error
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $category = CategoryProduct::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
