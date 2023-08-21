<?php

namespace App\Http\Resources\User\Chalets\ChaletById;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RandomChaletsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chalets_id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'space' => $this->space,
            'chalet_images' => ChaletImageResource::collection($this->chaletImages),
        ];
    }
}

class ChaletImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order' => $this->order,
            'image' => url('/') . Storage::url('chalets/images/' . $this->image),
        ];
    }
}
