<?php

namespace App\Http\Resources\User\Chalets;

use App\Http\Resources\Models\ChaletImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResearchedChaletsResource extends JsonResource
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
            'location' => $this->location,
            'space' => $this->space,
            'chalet_reservations_count' => $this->chalet_reservations_count,
            'chalet_images' => ChaletImageResource::collection($this->chaletImages),
        ];
    }
}
