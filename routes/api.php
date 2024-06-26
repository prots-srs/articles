<?php

/*
TO READ

https://quickstarts.postman.com/guide/php-laravel-API/index.html?index=..%2F..index#0
*/

use App\Http\Controllers\SanctumApiController;
use App\Http\Controllers\ContentAccessApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

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

Route::post('/sanctum/token', [SanctumApiController::class, 'login']);
Route::middleware('auth:sanctum')->post('/access', ContentAccessApiController::class);

Route::middleware('auth:sanctum')->get('/user', [SanctumApiController::class, 'getUser']);
Route::middleware('auth:sanctum')->patch('/user', [SanctumApiController::class, 'updateUser']);

Route::get('/article', [ArticleController::class, 'listApi']);
Route::get('/article/{article}', [ArticleController::class, 'itemApi']);
Route::middleware('auth:sanctum')->post('/article', [ArticleController::class, 'storeApi']);
Route::middleware('auth:sanctum')->delete('/article/{article}', [ArticleController::class, 'destroyApi']);
// Route::post('/put-test', [ArticleController::class, 'testStoreApi']);