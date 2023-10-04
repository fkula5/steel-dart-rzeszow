<?php

namespace App\Http\Resources;

use App\Models\FastOutType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FastOutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fastOut = FastOutType::findOrFail($this->fast_out_type_id);
        return [
            'id' => $this->id,
            'value' => $fastOut->value,
            'gameId' => $this->game_id
        ];
    }
}
