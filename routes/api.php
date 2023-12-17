<?php

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MyController extends Controller
{
    public function handle(Request $request): ResponseFactory|Response
    {
        return $this->makeResponse();
    }

    private function makeResponse(): ResponseFactory|Response
    {
        return response(['hello' => 'world']);
    }
}



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

Route::get('/orders', [MyController::class, 'handle']);
Route::post('/orders', [MyController::class, 'handle']);
Route::get('/orders/{order_id}', [MyController::class, 'handle']);
Route::put('/orders/{order_id}', [MyController::class, 'handle']);
Route::post('/orders/{order_id}/cancel', [MyController::class, 'handle']);
Route::post('/orders/{order_id}/pay', [MyController::class, 'handle']);
