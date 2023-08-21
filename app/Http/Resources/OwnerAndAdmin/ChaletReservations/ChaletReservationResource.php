<?php

namespace App\Http\Resources\OwnerAndAdmin\ChaletReservations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ChaletReservationResource extends JsonResource
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
            $userType = ChaletReservationObjectAutomaticUserResource::make($this->object['user']);
        } else {
            $userType = ChaletReservationObjectManualUserResource::make($this->object);
        }
        return [
            'id' => $this->id,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'user' => $userType,
        ];
    }
}

class ChaletReservationObjectAutomaticUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'account_picture' => url('/') . Storage::url('users/' . $this->account_picture),
            'name' => $this->first_name . ' ' . $this->last_name,
            'mobile' => $this->mobile,
        ];
    }
}

class ChaletReservationObjectManualUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'account_picture' => url('/') . Storage::url('users/user_profile.png'),
            'name' => $this->first_name . ' ' . $this->last_name,
            'mobile' => $this->mobile,
        ];
    }
}
