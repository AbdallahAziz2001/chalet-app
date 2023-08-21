<?php

namespace App\Http\Resources\OwnerAndAdmin\ChaletReservationNotifications;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChaletPendingReservationResource extends JsonResource
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
            'start_at' => $this->start_at,
            'period_start' => $this->period_start,
            'end_at' => $this->end_at,
            'period_end' => $this->period_end,
            'user' => ChaletPendingReservationObjectUserResource::make($this->object['user']),
        ];
    }
}

class ChaletPendingReservationObjectUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->first_name . ' ' . $this->last_name,
            'mobile' => $this->mobile,
            'chalet_rating_user_sum' => $this->chalet_rating_user_sum,
            'chalet_rating_user_count' => $this->chalet_rating_user_count,
        ];
    }
}
