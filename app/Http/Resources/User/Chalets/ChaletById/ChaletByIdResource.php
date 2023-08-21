<?php

namespace App\Http\Resources\User\Chalets\ChaletById;

use App\Http\Resources\Models\ChaletImageResource;
use App\Http\Resources\Models\ChaletMainFacilityResource;
use App\Http\Resources\Models\ChaletPolicyResource;
use App\Http\Resources\Models\ChaletPriceResource;
use App\Http\Resources\Models\ChaletTermResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ChaletByIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if (empty($this->userChaletStatusUsers)) {
            $isFavorite = false;
        } else {
            $isFavorite = true;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => url('/') . Storage::url('chalets/logos/' . $this->logo),
            'location' => $this->location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'country' => $this->country,
            'city' => $this->city,
            'description' => $this->description,
            'space' => $this->space,
            'is_favorite' => $this->isFavorite,
            'chalet_images' => ChaletImageResource::collection($this->chaletImages),
            'chalet_terms' => ChaletTermResource::collection($this->chaletTerms),
            'chalet_policies' => ChaletPolicyResource::collection($this->chaletPolicies),
            'chalet_prices' => ChaletPriceResource::collection($this->chaletPrices),
            'chalet_main_facilities' => ChaletMainFacilityResource::collection($this->chaletMainFacilities),
            'chalet_reservations' => ChaletReservationResource::collection($this->chaletReservations),
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
        ];
    }
}
