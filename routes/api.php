<?php

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

Route::post('/register', [App\Http\Controllers\Patients\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Patients\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Patients\AuthController::class, 'logout']);

Route::prefix('admin')->group(function () {
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout']);
});

Route::prefix('patients')->group(function () {
    Route::group(['middleware' => ['auth:api', 'role:Patients']], function () {

    });
});

Route::prefix('todos')->group(function () {
    $roles = ['Patients', 'Providers'];
    Route::group(['middleware' => ['auth:api', 'role:' . implode('|', $roles)]], function () {
        Route::get('', [App\Http\Controllers\Shared\TodoController::class, 'index']);
    });

    Route::patch('/todos/{todo}/complete', [App\Http\Controllers\Shared\TodoController::class, 'updateStatus']);
    Route::put('/todos/{todo}/archive', [App\Http\Controllers\Shared\TodoController::class, 'archive']);
    Route::put('/todos/{slug}/restore', [App\Http\Controllers\Shared\TodoController::class, 'restore']);
    Route::delete('/todos/{slug}/delete', [App\Http\Controllers\Shared\TodoController::class, 'destroy']);
});

Route::prefix('providers')->group(function () {
    // Route::post('/register', [App\Http\Controllers\Providers\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\Providers\AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:api', 'role:Providers']], function () {
        Route::post('/todos/create', [App\Http\Controllers\Shared\TodoController::class, 'create']);
        Route::put('/todos/{todo}/update', [App\Http\Controllers\Shared\TodoController::class, 'update']);
    });
});

Route::prefix('messages')->group(function () {
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/', [App\Http\Controllers\Shared\MessageController::class, 'getAllMessages']);
        Route::post('{id}/send', [App\Http\Controllers\Shared\MessageController::class, 'sendMessage']);
        Route::get('{id}/fetch', [App\Http\Controllers\Shared\MessageController::class, 'fetchMessages']);
        Route::get('unread', [App\Http\Controllers\Shared\MessageController::class, 'getUnreadMessages']);
        Route::patch('/{id}/mark-as-read', [App\Http\Controllers\Shared\MessageController::class, 'markMessageAsRead']);
        Route::delete('/{id}/delete', [App\Http\Controllers\Shared\MessageController::class, 'deleteMessage']);
    });
});
