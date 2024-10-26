<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

final class CreateNewGame implements Arrayable
{
    private int $playerOne;
    private int $playerTwo;
    private int $playerOneScore;
    private int $playerTwoScore;
    private float $playerOneAvg;
    private float $playerTwoAvg;
    private float $playerOneMaxAmount;
    private float $playerTwoMaxAmount;
    private int $league;
    private int $winner;
    private array $playerOneHighOuts;
    private array $playerTwoHighOuts;
    private array $playerOneFastOuts;
    private array $playerTwoFastOuts;


    public function __construct(
        int   $playerOne,
        int   $playerTwo,
        int   $playerOneScore,
        int   $playerTwoScore,
        float $playerOneAvg,
        float $playerTwoAvg,
        int   $playerOneMaxAmount,
        int   $playerTwoMaxAmount,
        int   $league,
        int   $winner,
        array $playerOneHighOuts,
        array $playerTwoHighOuts,
        array $playerOneFastOuts,
        array $playerTwoFastOuts

    )
    {
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
        $this->playerOneScore = $playerOneScore;
        $this->playerTwoScore = $playerTwoScore;
        $this->playerOneAvg = $playerOneAvg;
        $this->playerTwoAvg = $playerTwoAvg;
        $this->playerOneMaxAmount = $playerOneMaxAmount;
        $this->playerTwoMaxAmount = $playerTwoMaxAmount;
        $this->league = $league;
        $this->winner = $winner;
        $this->playerOneHighOuts = $playerOneHighOuts;
        $this->playerTwoHighOuts = $playerTwoHighOuts;
        $this->playerOneFastOuts = $playerOneFastOuts;
        $this->playerTwoFastOuts = $playerTwoFastOuts;
    }

    public function toArray(): array
    {
        return [
            'player_one' => $this->playerOne,
            'player_two' => $this->playerTwo,
            'player_one_score' => $this->playerOneScore,
            'player_two_score' => $this->playerTwoScore,
            'player_one_avg' => $this->playerOneAvg,
            'player_two_avg' => $this->playerTwoAvg,
            'player_one_max_amount' => $this->playerOneMaxAmount,
            'player_two_max_amount' => $this->playerTwoMaxAmount,
            'league_id' => $this->league,
            'winner' => $this->winner,
            'player_one_high_outs' => $this->playerOneHighOuts,
            'player_two_high_outs' => $this->playerTwoHighOuts,
            'player_one_fast_outs' => $this->playerOneFastOuts,
            'player_two_fast_outs' => $this->playerTwoFastOuts,
        ];
    }

    public function getPlayerOne(): int
    {
        return $this->playerOne;
    }

    public function getPlayerTwo(): int
    {
        return $this->playerTwo;
    }

    public function getPlayerOneScore(): int
    {
        return $this->playerOneScore;
    }

    public function getPlayerTwoScore(): int
    {
        return $this->playerTwoScore;

    }

    public function getPlayerOneAvg(): float
    {
        return $this->playerOneAvg;
    }

    public function getPlayerTwoAvg(): float
    {
        return $this->playerTwoAvg;
    }

    public function getPlayerOneMaxAmount(): int
    {
        return $this->playerOneMaxAmount;
    }

    public function getPlayerTwoMaxAmount(): int
    {
        return $this->playerTwoMaxAmount;
    }

    public function getLeague(): int
    {
        return $this->league;
    }

    public function getWinner(): int
    {
        return $this->winner;
    }

    public function getPlayerOneHighOuts(): array
    {
        return $this->playerOneHighOuts;
    }

    public function getPlayerTwoHighOuts(): array
    {
        return $this->playerTwoHighOuts;
    }

    public function getPlayerOneFastOuts(): array
    {
        return $this->playerOneFastOuts;
    }

    public function getPlayerTwoFastOuts(): array
    {
        return $this->playerTwoFastOuts;
    }
}
