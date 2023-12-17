<?php

use App\Http\Controllers\Controller;
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

Route::get('/orders', [Api\Orders::class, 'handle']);
Route::post('/orders', [Api\Orders::class, 'store']);
Route::get('/orders/{order_id}', [Controller::class, 'handle']);
Route::put('/orders/{order_id}', [Api\Orders::class, 'update']);
Route::post('/orders/{order_id}/cancel', [Controller::class, 'handle']);
Route::post('/orders/{order_id}/pay', [Controller::class, 'handle']);
