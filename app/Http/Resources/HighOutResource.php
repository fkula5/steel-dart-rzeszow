<?php

namespace App\Http\Resources;

use App\Models\HighOutType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HighOutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'high_out' => HighOutType::findOrFail($this->high_out_type_id)
        ];
    }
}
