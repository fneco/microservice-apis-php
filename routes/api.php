<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/orders', [Api\Orders::class, 'index']);
Route::post('/orders', [Api\Orders::class, 'store']);
Route::get('/orders/{order_id}', [Api\Orders::class, 'show']);
Route::put('/orders/{order_id}', [Api\Orders::class, 'update']);
Route::delete('/orders/{order_id}', [Api\Orders::class, 'destroy']);
Route::post('/orders/{order_id}/cancel', [Api\Orders::class, 'cancel']);
Route::post('/orders/{order_id}/pay', [Api\Orders::class, 'pay']);
