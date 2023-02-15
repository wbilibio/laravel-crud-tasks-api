<?php

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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Mail\UserChanged;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user', [AuthController::class, 'me']);
});

Route::group([
    'prefix' => 'user'
], function ($router) {

    Route::get('/list', [UserController::class, 'list']);
    Route::get('/get/{id}', [UserController::class, 'get']);
    Route::post('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);
});


Route::group(
    [
        'prefix' => 'task'
    ],
    function ($router) {

        Route::get('/list', [TaskController::class, 'list']);
        Route::get('/get/{id}', [TaskController::class, 'get']);
        Route::post('/save', [TaskController::class, 'store']);
        Route::post('/update/{id}', [TaskController::class, 'update']);
        Route::delete('/delete/{id}', [TaskController::class, 'destroy']);
    }
);
