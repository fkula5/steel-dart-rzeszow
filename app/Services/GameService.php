<?php

namespace App\Services;

use App\Models\FastOut;
use App\Models\Game;
use App\Models\HighOut;
use App\Models\Player;

class GameService
{
    private function updatePlayerStats(Game $game): void{
        $playerOne = Player::find($game->player_one);
        $playerOne->legs_won += $game->player_one_score;
        $playerOne->legs_lost += $game->player_two_score;
        $playerOne->balance = $playerOne->balance + $game->player_one_score - $game->player_two_score;
        $playerOne->average_3_dart = (($playerOne->avg + $game->player_one_avg)/2);
        $playerOne->max_amount += $game->player_one_max_amount;

        $playerTwo = Player::find($game->player_two);
        $playerTwo->legs_won += $game->player_two_score;
        $playerTwo->legs_lost += $game->player_one_score;
        $playerTwo->balance = $playerTwo->balance + $game->player_two_score - $game->player_one_score;
        $playerTwo->average_3_dart = (($playerTwo->avg + $game->player_two_avg)/2);
        $playerTwo->max_amount += $game->player_two_max_amount;

        if($game->winner == $game->player_one){
            $playerOne->points += 3;
        }elseif ($game->winner == $game->player_two){
            $playerOne->points += 3;
        }
        else{
            $playerOne->points += 1;
            $playerOne->points += 1;
        }

        $playerOne->save();
        $playerTwo->save();
    }

    private function createHighOuts(array $highOuts, Game $game): void
    {
        foreach ($highOuts as $highOut){
            HighOut::create([
                'player_id' => $highOut['player_id'],
                'game_id' => $game->id,
                'high_out_type_id' => $highOut['high_out_type']
            ]);
        }
    }

    private function createFastOuts(array $fastOuts, Game $game): void
    {
        foreach ($fastOuts as $fastOut){
            FastOut::create([
                'player_id' => $fastOut['player_id'],
                'game_id' => $game->id,
                'fast_out_type_id' => $fastOut['fast_out_type']
            ]);
        }
    }

    public function store(array $gameData): Game
    {
        $game = Game::create([
            'player_one' => $gameData['player_one'],
            'player_two' => $gameData['player_two'],
            'player_one_score' => $gameData['player_one_score'],
            'player_two_score' => $gameData['player_two_score'],
            'player_one_avg' => $gameData['player_one_avg'],
            'player_two_avg' => $gameData['player_two_avg'],
            'player_one_max_amount' => $gameData['player_one_max_amount'],
            'player_two_max_amount' => $gameData['player_two_max_amount'],
            'league_id' => $gameData['league_id'],
            'winner' => $gameData['winner']
        ]);

        $this->createHighOuts($gameData['highouts'], $game);

        $this->createFastOuts($gameData['fastouts'], $game);

        $this->updatePlayerStats($game);

        return $game;
    }

    public function update(Game $game, array $gameData): Game
    {
        $game->player_one = $gameData['player_one'];
        $game->player_two = $gameData['player_two'];
        $game->player_one_score = $gameData['player_one_score'];
        $game->player_two_score = $gameData['player_two_score'];
        $game->player_one_avg = $gameData['player_one_avg'];
        $game->player_two_avg = $gameData['player_two_avg'];
        $game->player_one_max_amount = $gameData['player_one_max_amount'];
        $game->player_two_max_amount = $gameData['player_two_max_amount'];
        $game->league_id = $gameData['league_id'];
        $game->winner = $gameData['winner'];

        $this->updatePlayerStats($game);

        $game->highOuts()->delete();

        $game->fastOuts()->delete();

        $this->createHighOuts($gameData['highouts'], $game);

        $this->createFastOuts($gameData['fastouts'], $game);

        $game->save();

        return $game;
    }
}
