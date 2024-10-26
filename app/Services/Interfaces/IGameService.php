<?php

namespace App\Services\Interfaces;

use App\Models\Game;
use App\ValueObjects\CreateNewGame;

interface IGameService
{
    public function store(CreateNewGame $gameData): Game;
}
