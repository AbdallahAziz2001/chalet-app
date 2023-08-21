<?php

namespace App\Http\Resources\User\Chalets;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ChaletsIAdminResource extends JsonResource
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
            'logo' => url('/') . Storage::url('chalets/logos/' . $this->logo),
            'name' => $this->name,
        ];
    }
}
