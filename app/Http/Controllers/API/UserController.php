<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function index()
    {
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::getToken();

        try {
            // Memeriksa validitas token
            $user = JWTAuth::toUser($token);
        } catch (JWTException $e) {
            // Jika token tidak valid, kembalikan respon error
            return response()->json([
                'success' => false,
                'message' => 'Invalid token',
            ], 401);
        }

        $users = User::all();

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    public function store(Request $request)
    {
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::getToken();
    
        try {
            // Memeriksa validitas token
            $user = JWTAuth::toUser($token);
        } catch (JWTException $e) {
            // Jika token tidak valid, kembalikan respon error
            return response()->json([
                'success' => false,
                'message' => 'Invalid token',
            ], 401);
        }
    
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|min:6',
            'role' => 'required|string|in:admin,kasir',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
    
    

    public function show($id)
    {
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::getToken();

        try {
            // Memeriksa validitas token
            $user = JWTAuth::toUser($token);
        } catch (JWTException $e) {
            // Jika token tidak valid, kembalikan respon error
            return response()->json([
                'success' => false,
                'message' => 'Invalid token',
            ], 401);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::getToken();

        try {
            // Memeriksa validitas token
            $user = JWTAuth::toUser($token);
        } catch (JWTException $e) {
            // Jika token tidak valid, kembalikan respon error
            return response()->json([
                'success' => false,
                'message' => 'Invalid token',
            ], 401);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        // Mendapatkan token dari header Authorization
        $token = JWTAuth::getToken();

        try {
            // Memeriksa validitas token
            $user = JWTAuth::toUser($token);
        } catch (JWTException $e) {
            // Jika token tidak valid, kembalikan respon error
            return response()->json([
                'success' => false,
                'message' => 'Invalid token',
            ], 401);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}

