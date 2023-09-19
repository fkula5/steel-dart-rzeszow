<?php

namespace App\Services;

use App\Models\FastOut;
use App\Models\FastOutType;
use App\Models\Game;
use App\Models\HighOut;
use App\Models\HighOutType;
use App\Models\Player;

class GameService
{
    private function updatePlayerStats(Game $game): void
    {
        $playerOne = Player::find($game->player_one);
        $playerOne->legs_won += $game->player_one_score;
        $playerOne->legs_lost += $game->player_two_score;
        $playerOne->balance = $playerOne->balance + $game->player_one_score - $game->player_two_score;
        $playerOne->average_3_dart = (($playerOne->avg + $game->player_one_avg) / 2);
        $playerOne->max_amount += $game->player_one_max_amount;

        $playerTwo = Player::find($game->player_two);
        $playerTwo->legs_won += $game->player_two_score;
        $playerTwo->legs_lost += $game->player_one_score;
        $playerTwo->balance = $playerTwo->balance + $game->player_two_score - $game->player_one_score;
        $playerTwo->average_3_dart = (($playerTwo->avg + $game->player_two_avg) / 2);
        $playerTwo->max_amount += $game->player_two_max_amount;

        if ($game->winner == $game->player_one) {
            $playerOne->points += 3;
        } elseif ($game->winner == $game->player_two) {
            $playerOne->points += 3;
        } else {
            $playerOne->points += 1;
            $playerOne->points += 1;
        }

        $playerOne->save();
        $playerTwo->save();
    }

    private function createHighOuts(array $highOuts, int $gameId, int $playerId): void
    {
        foreach ($highOuts as $highOut) {
            HighOut::create([
                'player_id' => $playerId,
                'game_id' => $gameId,
                'high_out_type_id' => HighOutType::where('value', $highOut)->value('id')
            ]);
        }
    }

    private function createFastOuts(array $fastOuts, int $gameId, int $playerId): void
    {
        foreach ($fastOuts as $fastOut) {
            FastOut::create([
                'player_id' => $playerId,
                'game_id' => $gameId,
                'fast_out_type_id' => FastOutType::where('value', $fastOut)->value('id')
            ]);
        }
    }

    public function store(array $gameData): Game
    {
        $game = Game::create($gameData);

        $this->createHighOuts($gameData['player_one_high_outs'], $game->id, $game->player_one);
        $this->createFastOuts($gameData['player_one_fast_outs'], $game->id, $game->player_one);

        $this->createHighOuts($gameData['player_two_high_outs'], $game->id, $game->player_two);
        $this->createFastOuts($gameData['player_two_fast_outs'], $game->id, $game->player_two);

        $this->updatePlayerStats($game);

        return $game;
    }

    public function update(Game $game, array $gameData): Game
    {
        $game->update($gameData);

        $this->updatePlayerStats($game);

        $game->highOuts()->delete();

        $game->fastOuts()->delete();

        $this->createHighOuts($gameData['high_outs'], $game);

        $this->createFastOuts($gameData['fast_outs'], $game);

        return $game;
    }
}
