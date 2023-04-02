<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

// User routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/resetPasswordRequest', [AuthController::class, 'resetPasswordRequest']);
Route::post('/resetPassword', [AuthController::class, 'resetPassword']);

// Tasks routes
Route::post('/newTask', [AuthController::class, 'newTask']);
Route::get('/getTasks', [AuthController::class, 'getTasks']);
Route::delete('/deleteTask/{id}', [AuthController::class, 'deleteTask']);
Route::put('/updateTask/{id}', [AuthController::class, 'updateTask']);
