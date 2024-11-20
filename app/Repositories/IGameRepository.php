<?php

namespace App\Repositories;

use App\Models\Game;
use App\ValueObjects\CreateNewGame;

interface IGameRepository
{
    public function create(CreateNewGame $game): Game;
}
