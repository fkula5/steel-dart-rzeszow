<?php

namespace App\Repositories;

use App\Models\Game;
use App\ValueObjects\CreateNewGame;

final class GameRepository implements IGameRepository
{
    public function create(CreateNewGame $game): Game
    {
        dd($game->toArray());
        return Game::create(...$game->toArray());
    }
}
