<?php

use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\CardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ColumnController::class)->group(function () {
    Route::get('columns', 'index');
    Route::post('columns/store', 'store');
    Route::put('columns/reorder', 'reorder');
    Route::delete('columns/{column}/delete', 'destroy');
});

Route::controller(CardController::class)->group(function () {
    Route::get('list-cards', 'index');
    Route::post('cards/{column}/store', 'store');
    Route::put('cards/{card}/reorder', 'reorder');
    Route::post('cards/{card}/update-title', 'updateTitle');
    Route::post('cards/{card}/update-description', 'updateDescription');
});


