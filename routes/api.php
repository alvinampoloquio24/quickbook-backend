<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;

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
    Route::put('updateSelf', [AuthController::class, 'updateSelf']);
    // Route::post('refresh', 'AuthController@refresh');
    Route::post('me',  [AuthController::class, 'me']);
});

// Listings routes
// Public: Read-only (all users)
Route::get('listings', [ListingController::class, 'index']);
Route::get('getListing/{listing}', [ListingController::class, 'getListing']);

// Protected: Create, Update, Delete (authenticated users only)
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('addListing', [ListingController::class, 'addListing']);
    Route::put('updateListing/{listing}', [ListingController::class, 'updateListing']);
    Route::delete('deleteListing/{listing}', [ListingController::class, 'deleteListing']);
});
