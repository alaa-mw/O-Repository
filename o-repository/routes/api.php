<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\MoodelController;
use App\Http\Controllers\ShoeColorsController;
use App\Http\Controllers\ShoeController;
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

Route::post('admin-login', [AuthController::class, 'adminLogin']);
// 'role:admin'  No space after colon
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'role:admin']], function () {


    Route::post('logout', [AuthController::class, 'adminLogout']);

    Route::controller(MoodelController::class)->group(function () {

        Route::get('list-models', 'index');
        Route::post('add-model', 'create');
    });

    Route::controller(ShoeController::class)->group(function () {

        Route::post('list-shoes-of-model', 'getShoesOfModel');
        Route::post('add-shoe', 'create');
    });

    Route::controller(ShoeColorsController::class)->group(function () {

        Route::post('list-colors-of-shoe', 'getColorsOfShoe');
    });


    Route::controller(ColorController::class)->group(function () {

        Route::get('list-colors', 'index');
    });
});
