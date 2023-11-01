<?php

namespace Database\Seeders;

use App\Models\FastOut;
use App\Models\FastOutType;
use App\Models\Game;
use App\Models\HighOut;
use App\Models\HighOutType;
use App\Models\Player;
use Illuminate\Database\Seeder;

class DummyGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = file_get_contents(__DIR__.'/data/dummy_games.json');
        $data = json_decode($jsonFile);
        foreach ($data->games as $value) {
            $game = Game::create([
                "player_one" => $value->player_one,
                "player_two" => $value->player_two,
                "player_one_score" => $value->player_one_score,
                "player_two_score" => $value->player_two_score,
                "player_one_avg" => $value->player_one_avg,
                "player_two_avg" => $value->player_two_avg,
                "player_one_max_amount" => $value->player_one_max_amount,
                "player_two_max_amount" => $value->player_two_max_amount,
                "league_id" => $value->league_id,
                "winner" => $value->winner
            ]);
            $this->createHighOuts($value->player_one_high_outs, $game, $game->player_one);
            $this->createFastOuts($value->player_one_fast_outs, $game, $game->player_one);

            $this->createHighOuts($value->player_two_high_outs, $game, $game->player_two);
            $this->createFastOuts($value->player_two_fast_outs, $game, $game->player_two);

            $this->updatePlayersStats($game);
        }
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

        $this->updatePlayerStats($playerOne, $game->player_one_score, $game->player_two_score, $game->player_one_avg,
            $game->player_one_max_amount);

        $this->updatePlayerStats($playerTwo, $game->player_two_score, $game->player_one_score, $game->player_two_avg,
            $game->player_two_max_amount);
    }

    private function updatePlayerStats(Player $player, int $score, int $opponentScore, float $avg, int $max): void
    {
        $player->legs_won += $score;
        $player->legs_lost += $opponentScore;
        $player->balance = $player->balance + $score - $opponentScore;
        $player->average_3_dart = (($player->average_3_dart + $avg) / 2);
        $player->max_amount += $max;
        $player->save();
    }
}
