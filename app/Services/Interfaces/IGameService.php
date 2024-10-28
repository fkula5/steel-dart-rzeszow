<?php

namespace App\Services\Interfaces;

use App\Models\Game;
use App\ValueObjects\CreateNewGame;
use Illuminate\Database\Eloquent\Collection;

interface IGameService
{
    public function store(CreateNewGame $gameData): Game;

    public function update(Game $game, array $gameData);

    public function index(): Collection;
}
