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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('players', PlayerController::class);

Route::get('leagues/{league}/players', [PlayerController::class, 'playersLeague']);

Route::apiResource('games', GameController::class);

Route::get('recentLeagueGames/{league}', [GameController::class, 'recentLeagueGames']);
