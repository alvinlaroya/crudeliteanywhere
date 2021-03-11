<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\OrganizationController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/persons', [PersonController::class, 'index']);
Route::prefix('/person')->group(function() {
    Route::post('/store', [PersonController::class, 'store']);
    Route::put('/{id}', [PersonController::class, 'update']);
    Route::delete('/{id}', [PersonController::class, 'destroy']);
});

Route::get('/organizations', [OrganizationController::class, 'index']);
Route::get('/organizationsBelong/{id}', [OrganizationController::class, 'getAllUsersByOrganization']);
Route::prefix('/organization')->group(function() {
    Route::post('/store', [OrganizationController::class, 'store']);
    Route::put('/{id}', [OrganizationController::class, 'update']);
    Route::delete('/{id}', [OrganizationController::class, 'destroy']);
});
