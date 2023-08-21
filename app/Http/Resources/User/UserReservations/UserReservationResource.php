<?php

namespace App\Http\Resources\User\UserReservations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chalet_reservation' => ChaletReservationResource::make($this->chaletReservation)
        ];
    }
}

class ChaletReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'chalet' => ChaletResource::make($this->chalet),
        ];
    }
}

class ChaletResource extends JsonResource
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
            'logo' => url('/') . Storage::url('chalets/logos/' . $this->logo),
            'location' => $this->location,
            'space' => $this->space,
        ];
    }
}
