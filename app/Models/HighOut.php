<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HighOut extends Model
{
    use HasFactory;

    protected $fillable = ['high_out_type_id', 'player_id', 'game_id'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function highOutType(): BelongsTo
    {
        return $this->belongsTo(HighOutType::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
