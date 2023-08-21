<?php

namespace App\Http\Resources\OwnerAndAdmin\ChaletReservationNotifications;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChaletCompletedReservationResource extends JsonResource
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
            $userType = ChaletCompletedReservationObjectAutomaticUserResource::make($this->object['user']);
        } else {
            $userType = ChaletCompletedReservationObjectManualUserResource::make($this->object);
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

class ChaletCompletedReservationObjectAutomaticUserResource extends JsonResource
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

class ChaletCompletedReservationObjectManualUserResource extends JsonResource
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
