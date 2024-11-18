<?php

use Illuminate\Http\Request;
use App\Services\RajaOngkirService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware('auth:api')->get('/cart/count', [CartController::class, 'getCartCount']);
Route::post('/midtrans/callback', [PaymentController::class, 'handleCallback']);
Route::post('/calculate-shipping-cost', [CartController::class, 'calculateShippingCost']);

