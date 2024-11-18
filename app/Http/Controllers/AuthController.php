<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register()
{
    $validator = Validator::make(request()->all(), [
        'name' => 'required|string|min:2',
        'email' => 'required|string|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    if($validator->fails()){
        return response()->json($validator->messages());
    }

    $user = User::create([
        'name' => request('name'),
        'email' => request('email'),
        'password' => Hash::make(request('password')),
    ]);

    if($user){
        return response()->json(['message' => 'User registered successfully'], 201);
    }else{
        return response()->json(['message' => 'User registered failed']);
    }
}


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt(array_merge($credentials, ['status' => 'active']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // request()->session()->flash('status', 'Logged in successfully!');

        // return $this->respondWithToken($token);
        
        // Mengambil pengguna yang sudah terautentikasi
        $user = Auth::user();

        // Membuat payload dengan informasi penting
        $payload = [
            'sub' => $user->id,       // ID pengguna
            'role' => $user->role,    // Peran pengguna (admin, user, dll.)
            'exp' => now()->addHours(2)->timestamp, // Waktu kadaluwarsa token
        ];

        // Menghasilkan token dengan klaim
        $token = JWTAuth::claims($payload)->fromUser($user);

        // Mengembalikan respons JSON dengan token dan informasi pengguna
        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully!',
            'token' => $token,
        ]);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh()); 
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
