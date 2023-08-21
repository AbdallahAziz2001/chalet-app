<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ChaletMainFacilityResource extends JsonResource
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
            'icon' => url('/') . Storage::url('chalets/facilities/' . $this->icon),
            'title' => $this->title,
            'chalet_main_facility_sub_facilities' => ChaletMainFacilitySubFacilityResource::collection($this->chaletMainFacilitySubFacilities),
        ];
    }
}

class ChaletMainFacilitySubFacilityResource extends JsonResource
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
            'chalet_main_facility_id' => $this->chalet_main_facility_id,
            'title' => $this->title,
        ];
    }
}
