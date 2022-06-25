<?php

use App\Http\Controllers\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::post('/auth/register', [authController::class, 'register']);
Route::post('/auth/login', [authController::class, 'login']);


Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::Get('/auth/getUser/{id}', [authController::class, 'getUser']);
    Route::put('/auth/updateUser/{id}', [authController::class, 'updateUser']);
    Route::post('/auth/logout/{id}', [authController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
