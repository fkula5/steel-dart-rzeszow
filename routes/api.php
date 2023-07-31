<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PlayerController::class)->group(function () {
    Route::get('players', 'index');
    Route::get('players/{id}', 'show');
    Route::post('players', 'store');
    Route::delete('players/{id}', 'destroy');
    Route::put('players/{id}', 'update');
});

Route::controller(GameController::class)->group(function () {
    Route::get('games', 'index');
    Route::get('games/{id}', 'show');
    Route::post('games', 'store');
    Route::delete('games/{id}', 'destroy');
    Route::put('games/{id}', 'update');
});
