<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
     // Get user info from token
    public function me(Request $request){
          // Get bearer token from request
        $token = $request->bearerToken();

        // If no token
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token missing.'
            ], 401);
        }
        // Find token in database
        $accessToken = PersonalAccessToken::findToken($token);

         // If token not found or expired
        if (!$accessToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired token.'
            ], 401);
        }

        $user = $accessToken->tokenable;
        // Return user info
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user
            ]
        ]);
    }
    // Register new user
    public function register(Request $request){
  
        $validated  = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Create new user with hashed password
            $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;
         // Return user with token
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' =>$token
        ]);
        }catch (\Exception $e) {
             // Catch any errors
             return response()->json([
                'status' => 'error',
                'message' => 'Registration failed.',
                'error' => $e->getMessage(),
             ]);
        }
    }
    // Login user
    public function login(Request $request){
         $validated = $request->validate([
            'email'=> 'required|string|email',
            'password'=> 'required|string',
        ]);
        // Find user by email
        $user = User::where('email',$validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)){
            throw ValidationException::withMessages([
                'email' => ['Invalid Credentials'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token
        ]);
    }
    // Logout user
    public function logout(Request $request){
         // Get bearer token
        $token = $request->bearerToken();
        // If token is missing
        if (!$token) {
            return response()->json(['error' => 'Token missing.'], 401);
        }
        // Find token record
        $accessToken = PersonalAccessToken::findToken($token);
         // If invalid or expired
        if (!$accessToken) {
            return response()->json(['error' => 'Invalid or expired token.'], 401);
        }
         // Get user from token
        $user = $accessToken->tokenable;
         // If no user found
        if (!$user) {
            return response()->json(['error' => 'Invalid or expired token.'], 401);
        }
         // Delete only current token
        $accessToken->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logged out successfully.',
        ]);
    
    }

}
