<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Cliente\ClienteController;
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

Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['apiJwt']], function() {
    route::get('/logout', [AuthController::class, 'logout']);
    route::get('/refresh', [AuthController::class, 'refresh']);
});

Route::post('/store', [ClienteController::class, 'store']);
