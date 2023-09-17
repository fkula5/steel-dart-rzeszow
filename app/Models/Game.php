<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['player_one', 'player_two', 'player_one_score', 'player_two_score', 'player_one_avg', 'player_two_avg', 'player_one_max_amount', 'player_two_max_amount', 'league_id', 'winner'];

    public function getPlayerHighOuts($playerId): Collection {
        return $this->highOuts()->where('player_id', $playerId)->get();
    }
    public function getPlayerFastOuts($playerId): Collection {
        return $this->fastOuts()->where('player_id', $playerId)->get();
    }

    public function highOuts(): HasMany
    {
        return $this->hasMany(HighOut::class);
    }

    public function fastOuts(): HasMany
    {
        return $this->hasMany(FastOut::class);
    }

    public function playerOne(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_one');
    }

    public function playerTwo(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_two');
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class, 'league_id');
    }
}
