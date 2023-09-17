<?php

namespace App\Http\Resources;

use App\Models\Game;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $game = Game::find($this->id);
        return [
            'id' => $this->id,
            'player_one' => new PlayerResource($this->whenLoaded('playerOne')),
            'player_two' => new PlayerResource($this->whenLoaded('playerTwo')),
            'player_one_score' => $this->player_one_score,
            'player_two_score' => $this->player_two_score,
            'player_one_avg' => (float)$this->player_one_avg,
            'player_two_avg' => (float)$this->player_two_avg,
            'player_one_max_amount' => $this->player_one_max_amount,
            'player_two_max_amount' => $this->player_two_max_amount,
            'player_one_high_outs' => new HighOutCollection($game->getPlayerHighOuts($this->player_one)),
            'player_two_high_outs' => new HighOutCollection($game->getPlayerHighOuts($this->player_two)),
            'player_one_fast_outs' => new FastOutCollection($game->getPlayerFastOuts($this->player_one)),
            'player_two_fast_outs' => new FastOutCollection($game->getPlayerFastOuts($this->player_two)),
            'league' => new LeagueResource($this->whenLoaded('league')),
            'winner' => $this->winner,
            'created_at' => $this->created_at->format('d.m.Y'),
            'updated_at' => $this->updated_at->format('d.m.Y')
        ];
    }
}
