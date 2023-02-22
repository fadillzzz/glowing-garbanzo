<?php

use App\Http\Controllers\Auth\TokensController;
use App\Http\Controllers\Users\Posts\PostsController;
use App\Http\Controllers\Users\UsersController;
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

Route::post('/tokens', [TokensController::class, 'store']);

Route::middleware('role:admin')->group(function () {
    Route::get('/users', [UsersController::class, 'index']);
    Route::post('/users', [UsersController::class, 'store']);
    Route::patch('/users/{id}', [UsersController::class, 'update']);
    Route::delete('/users/{id}', [UsersController::class, 'destroy']);
});

Route::get('/users/{id}/posts', [PostsController::class, 'index']);

Route::middleware(['role:admin,manager,user', 'permission:id'])->group(function () {
    Route::post('/users/{id}/posts', [PostsController::class, 'store']);
    Route::patch('/users/{id}/posts/{postId}', [PostsController::class, 'update']);
    Route::delete('/users/{id}/posts/{postId}', [PostsController::class, 'destroy']);
});

