<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//AUTH

Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/auth', [AuthController::class, 'auth']);

//USERS

Route::get('/users', [UserController::class, 'index']);
Route::post('/userEdit', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

//ORDERS
Route::get('/orders', [ordersController::class, 'index']);