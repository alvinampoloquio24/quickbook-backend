<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

//public
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

//auth routes
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::get('me', [AuthController::class, 'me']);
    // Route::post('refresh', 'AuthController@refresh');
    Route::post('me',  [AuthController::class, 'me']);
});
