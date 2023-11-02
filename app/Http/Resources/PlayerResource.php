<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'secondName' => $this->second_name,
            'league' => new LeagueResource($this->whenLoaded('league')),
            'points' => $this->points,
            'balance' => $this->balance,
            'legsWon' => $this->legs_won,
            'legsLost' => $this->legs_lost,
            'average3Darts' => $this->average_3_dart ? round($this->average_3_dart, 2) : 0,
            'maxAmount' => $this->max_amount,
            'highOuts' => new HighOutCollection($this->whenLoaded('highOuts')),
            'fastOuts' => new FastOutCollection($this->whenLoaded('fastOuts'))
        ];
    }
}
