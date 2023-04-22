<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExchangeRateController;
use App\Http\Controllers\Api\PostController;
use App\Http\Middleware\Roles;
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
//Route::apiResource('posts', PostController::class)->middleware('auth:sanctum')->middleware('roles:admin');
Route::get('/posts', [PostController::class,'index']);
Route::post('/posts',[PostController::class, 'store'])->middleware('auth:sanctum')->middleware('roles:admin');
Route::put('/posts/{id}',[PostController::class, 'update'])->middleware('auth:sanctum')->middleware('roles:admin');
Route::get('/posts/{id}', [PostController::class,'show']);
Route::delete('/posts/{id}',[PostController::class,'destroy'])->middleware('auth:sanctum')->middleware('roles:admin');

Route::get('/exchange_rates',[ExchangeRateController::class, 'index'])->middleware('auth:sanctum');
Route::get('/exchange_rates/{date}',[ExchangeRateController::class, 'index'])->middleware('auth:sanctum');
Route::get('/exchange_rates/{currency}/{date}',[ExchangeRateController::class, 'show'])->middleware('auth:sanctum');
Route::post('/exchange_rates',[ExchangeRateController::class, 'store'])
    ->middleware('auth:sanctum')
    ->middleware('roles:admin');


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
