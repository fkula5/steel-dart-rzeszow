<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'second_name', 'points', 'balance', 'legs_won', 'legs_lost', 'average_3_dart', 'max_amount', 'league_id'];

    public function fastOuts(): hasMany
    {
        return $this->hasMany(FastOut::class);
    }

    public function highOuts(): HasMany
    {
        return $this->hasMany(HighOut::class);
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function playerOneGames(): HasMany
    {
        return $this->hasMany(Game::class, 'player_one');
    }

    public function playerTwoGames(): HasMany
    {
        return $this->hasMany(Game::class, 'player_two');
    }
}
