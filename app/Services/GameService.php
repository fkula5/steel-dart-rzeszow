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
    private function updatePlayerStats(Player $player, $score, $opponentScore, $avg, $max): void
    {
        $player->legs_won += $score;
        $player->legs_lost += $opponentScore;
        $player->balance = $player->balance + $score - $opponentScore;
        $player->average_3_dart = (($player->avg + $avg) / 2);
        $player->max_amount += $max;
        $player->save();
    }
    private function updatePlayersStats(Game $game): void
    {
        $playerOne = Player::find($game->player_one);
        $playerTwo = Player::find($game->player_two);

        if ($game->winner == $game->player_one) {
            $playerOne->points += 3;
        } elseif ($game->winner == $game->player_two) {
            $playerTwo->points += 3;
        } else {
            $playerOne->points += 1;
            $playerOne->points += 1;
        }

        $this->updatePlayerStats($playerOne, $game->player_one_score, $game->player_two_score, $game->player_one_avg, $game->player_one_max);

        $this->updatePlayerStats($playerTwo, $game->player_two_score, $game->player_one_score, $game->player_two_avg, $game->player_two_max);
    }

    private function createHighOuts(array $highOuts, Game $game, int $playerId): void
    {
        foreach ($highOuts as $highOut) {
            HighOut::create([
                'player_id' => $playerId,
                'game_id' => $game->id,
                'high_out_type_id' => HighOutType::where('value', $highOut)->value('id')
            ]);
        }
    }

    private function createFastOuts(array $fastOuts, Game $game, int $playerId): void
    {
        foreach ($fastOuts as $fastOut) {
            FastOut::create([
                'player_id' => $playerId,
                'game_id' => $game->id,
                'fast_out_type_id' => FastOutType::where('value', $fastOut)->value('id')
            ]);
        }
    }

    public function store(array $gameData): Game
    {
        $game = Game::create($gameData);

        $this->createHighOuts($gameData['player_one_high_outs'], $game, $game->player_one);
        $this->createFastOuts($gameData['player_one_fast_outs'], $game, $game->player_one);

        $this->createHighOuts($gameData['player_two_high_outs'], $game, $game->player_two);
        $this->createFastOuts($gameData['player_two_fast_outs'], $game, $game->player_two);

        $this->updatePlayersStats($game);

        return $game;
    }

    public function update(Game $game, array $gameData): Game
    {
        $game->update($gameData);

        $this->updatePlayersStats($game);

        $game->highOuts()->delete();

        $game->fastOuts()->delete();

        $this->createHighOuts($gameData['player_one_high_outs'], $game, $game->player_one);
        $this->createFastOuts($gameData['player_one_fast_outs'], $game, $game->player_one);

        $this->createHighOuts($gameData['player_two_high_outs'], $game, $game->player_two);
        $this->createFastOuts($gameData['player_two_fast_outs'], $game, $game->player_two);

        return $game;
    }
}
