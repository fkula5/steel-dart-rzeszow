<?php

namespace App\Services;

use App\Models\Player;

class PlayerService
{
    public function create(array $playerData): Player
    {
        return Player::create($playerData);
    }

    public function update(Player $player, array $playerData): Player
    {
        $player->name = $playerData['name'];
        $player->second_name = $playerData['second_name'];
        $player->league_id = $playerData['league_id'];

        $player->save();

        return $player;
    }
}
