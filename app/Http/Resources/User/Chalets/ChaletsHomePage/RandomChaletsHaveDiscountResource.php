<?php

namespace App\Http\Resources\User\Chalets\ChaletsHomePage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RandomChaletsHaveDiscountResource extends JsonResource
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
            'chalet_images' => RandomChaletsHaveDiscountChaletImageResource::collection($this->chaletImages),
            'chalet_prices' => RandomChaletsHaveDiscountChaletPriceResource::collection($this->chaletPrices),
        ];
    }
}

class RandomChaletsHaveDiscountChaletImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order' => $this->order,
            'image' => url('/') . Storage::url('chalets/images/' . $this->image)
        ];
    }
}

class RandomChaletsHaveDiscountChaletPriceResource extends JsonResource
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
            'chalet_price_discount_codes' => RandomChaletsHaveDiscountChaletPriceDiscountCodeResource::collection($this->chaletPriceDiscountCodes),
        ];
    }
}

class RandomChaletsHaveDiscountChaletPriceDiscountCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'percent' => $this->percent,
        ];
    }
}
