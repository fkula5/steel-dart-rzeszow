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
            'playerOne' => new PlayerResource($this->whenLoaded('playerOne')),
            'playerTwo' => new PlayerResource($this->whenLoaded('playerTwo')),
            'playerOneScore' => $this->player_one_score,
            'playerTwoScore' => $this->player_two_score,
            'playerOneAvg' => (float)$this->player_one_avg,
            'playerTwoAvg' => (float)$this->player_two_avg,
            'playerOneMaxAmount' => $this->player_one_max_amount,
            'playerTwoMaxAmount' => $this->player_two_max_amount,
            'playerOneHighOuts' => new HighOutCollection($game->getPlayerHighOuts($this->player_one)),
            'playerTwoHighOuts' => new HighOutCollection($game->getPlayerHighOuts($this->player_two)),
            'playerOneFastOuts' => new FastOutCollection($game->getPlayerFastOuts($this->player_one)),
            'playerTwoFastOuts' => new FastOutCollection($game->getPlayerFastOuts($this->player_two)),
            'league' => new LeagueResource($this->whenLoaded('league')),
            'winner' => $this->winner,
            'created_at' => $this->created_at->format('d.m.Y'),
            'updated_at' => $this->updated_at->format('d.m.Y')
        ];
    }
}
