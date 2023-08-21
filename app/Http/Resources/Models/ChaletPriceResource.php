<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChaletPriceResource extends JsonResource
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
            'average_price' => $this->average_price,
            'saturday_am' => $this->saturday_am,
            'saturday_pm' => $this->saturday_pm,
            'sunday_am' => $this->sunday_am,
            'sunday_pm' => $this->sunday_pm,
            'monday_am' => $this->monday_am,
            'monday_pm' => $this->monday_pm,
            'tuesday_am' => $this->tuesday_am,
            'tuesday_pm' => $this->tuesday_pm,
            'wednesday_am' => $this->wednesday_am,
            'wednesday_pm' => $this->wednesday_pm,
            'thursday_am' => $this->thursday_am,
            'thursday_pm' => $this->thursday_pm,
            'friday_am' => $this->friday_am,
            'friday_pm' => $this->friday_pm,
        ];
    }
}
