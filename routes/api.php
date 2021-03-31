<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Email\SendMailController;
use App\Http\Controllers\Api\Radios\RadiosMoveisController;
use App\Http\Controllers\Api\Radios\RadiosPortateisController;
use App\Http\Controllers\Api\User\UserController;
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

Route::post('/store', [UserController::class, 'store']);

Route::post('/send-mail', [SendMailController::class, 'sendMail']);

Route::get('/send-link/{id}', [SendMailController::class, 'verifyToken']);

Route::put('/change-password/{id}', [SendMailController::class, 'changePassword']);

Route::group(['middleware' => ['apiJwt']], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refresh']);

    Route::resource('/users', UserController::class);

    Route::get('/radios-moveis/filter', [RadiosMoveisController::class, 'filter']);
    Route::resource('/radios-moveis', RadiosMoveisController::class);

    Route::prefix('/radios-portateis')->group(function () {
        Route::get('/index', [RadiosPortateisController::class, 'index']);
        Route::get('/filter', [RadiosPortateisController::class, 'filter']);
        Route::post('/store', [RadiosPortateisController::class, 'store']);
        Route::delete('/destroy/{id}', [RadiosPortateisController::class, 'destroy']);
        Route::post('/update/{id}', [RadiosPortateisController::class, 'update']);
    });
});
