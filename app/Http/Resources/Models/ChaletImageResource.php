<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'id' => $this->id,
            'chalets_id' => $this->chalets_id,
            'order' => $this->order,
            'image' => url('/') . Storage::url('chalets/images/' . $this->image),
        ];
    }
}
