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

Route::post('admin/login', [AuthController::class, 'adminLogin'])->name('adminLogin');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    // authenticated staff routes here
    Route::post('logout', [AuthController::class, 'adminLogout']);

    Route::get('listAllMedicines', [AdminMedicineController::class, 'listAllMedicines']);
    Route::post('addMedicine', [AdminMedicineController::class, 'add']);
    Route::get('/search/{name}', [MedicineController::class, 'search']);
});
