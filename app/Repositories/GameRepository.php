<?php

namespace App\Repositories;

use App\Models\Game;
use App\ValueObjects\CreateNewGame;

final class GameRepository implements IGameRepository
{
    public function create(CreateNewGame $game): Game
    {
        $gameData = $game->toArray();
        return Game::create([
            'player_one' => $gameData['player_one'],
            'player_two' => $gameData['player_two'],
            'player_one_score' => $gameData['player_one_score'],
            'player_two_score' => $gameData['player_two_score'],
            'player_one_avg' => $gameData['player_one_avg'],
            'player_two_avg' => $gameData['player_two_avg'],
            'player_one_max_amount' => $gameData['player_one_max_amount'],
            'player_two_max_amount' => $gameData['player_two_max_amount'],
            'league_id' => $gameData['league_id'],
            'winner' => $gameData['winner'],
        ]);
    }
}
