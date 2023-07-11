<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['player_one_score', 'player_two_score', 'player_one_avg', 'player_two_avg', 'player_one_count_180', 'player_two_count_180'];

    public function high_outs(): HasMany
    {
        return $this->hasMany(HighOut::class);
    }

    public function fast_outs(): HasMany
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
}
