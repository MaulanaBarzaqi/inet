<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user,
        ], 201);
    }

    function login(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = User::where('email', $request->email)->firstOrfail();

       $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User login successfully',
            'data' => $user,
            'token' => $token,
        ], 201);
    }

    public function updateFcmToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'unauthorized',
            ], 401);
        }
           User::where('id', $user->id)->update([
            'fcm_token' => $request->fcm_token
        ]);

        return response()->json([
            'message' => 'FCM token updated successfully',
        ], 201);
    }

    public function removeFcmToken(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'unathorized',
            ], 401);
        }
        // Set fcm_token menjadi null
        User::where('id', $user->id)->update([
            'fcm_token' => null
        ]);

          return response()->json([
            'message' => 'FCM token removed successfully',
        ], 200);
    }
}
