<?php

namespace App\Services;

use App\Models\FastOut;
use App\Models\FastOutType;
use App\Models\Game;
use App\Models\HighOut;
use App\Models\HighOutType;
use App\Models\Player;
use App\Repositories\GameRepository;
use App\Services\Interfaces\IGameService;
use App\ValueObjects\CreateNewGame;

class GameService implements IGameService
{
    public function __construct(private GameRepository $gameRepository)
    {
    }

    public function store(CreateNewGame $gameData): Game
    {
        $game = $this->gameRepository->create($gameData);

        $this->createOuts($gameData, $game);

        $this->updatePlayersStats($game);

        return $game;
    }

    public function createOuts(CreateNewGame $gameData, Game $game): void
    {
        $this->createHighOuts($gameData->getPlayerOneHighOuts(), $gameData->getPlayerOne(), $game->id);
        $this->createHighOuts($gameData->getPlayerTwoHighOuts(), $gameData->getPlayerTwo(), $game->id);
        $this->createFastOuts($gameData->getPlayerOneFastOuts(), $gameData->getPlayerOne(), $game->id);
        $this->createFastOuts($gameData->getPlayerTwoFastOuts(), $gameData->getPlayerTwo(), $game->id);
    }

    private function createHighOuts(array $highOuts, int $playerId, int $gameId): void
    {
        foreach ($highOuts as $highOut) {
            HighOut::create([
                'player_id' => $playerId,
                'game_id' => $gameId,
                'high_out_type_id' => HighOutType::where('value', $highOut)->value('id'),
            ]);
        }
    }

    private function createFastOuts(array $fastOuts, int $playerId, int $gameId): void
    {
        foreach ($fastOuts as $fastOut) {
            FastOut::create([
                'player_id' => $playerId,
                'game_id' => $gameId,
                'fast_out_type_id' => FastOutType::where('value', $fastOut)->value('id'),
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

        $this->updatePlayerStats($playerOne, $game->player_one_score, $game->player_two_score, $game->player_one_avg, $game->player_one_max_amount);

        $this->updatePlayerStats($playerTwo, $game->player_two_score, $game->player_one_score, $game->player_two_avg, $game->player_two_max_amount);
    }

    private function updatePlayerStats(Player $player, int $score, int $opponentScore, float $avg, int $max): void
    {
        $player->legs_won += $score;
        $player->legs_lost += $opponentScore;
        $player->balance = $player->balance + $score - $opponentScore;
        $player->average_3_dart = (($player->avg + $avg) / 2);
        $player->max_amount += $max;
        $player->save();
    }

    public function update(Game $game, array $gameData): Game
    {
        $game->update($gameData);

        $this->updatePlayersStats($game);

        $game->highOuts()->delete();

        $game->fastOuts()->delete();

        $this->createOuts($gameData, $game);

        return $game;
    }

}
