<?php

namespace App\Http\Resources\OwnerAndAdmin\ChaletReservationNotifications;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChaletAcceptedReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $userType = 'No User';
        if ($this->object_type == 'App\Models\ChaletAutomaticReservation') {
            $userType = ChaletAcceptedReservationObjectAutomaticUserResource::make($this->object['user']);
        } else {
            $userType = ChaletAcceptedReservationObjectManualUserResource::make($this->object);
        }

        return [
            'id' => $this->id,
            'start_at' => $this->start_at,
            'period_start' => $this->period_start,
            'end_at' => $this->end_at,
            'period_end' => $this->period_end,
            'user' => $userType,
        ];
    }
}

class ChaletAcceptedReservationObjectAutomaticUserResource extends JsonResource
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

class ChaletAcceptedReservationObjectManualUserResource extends JsonResource
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
