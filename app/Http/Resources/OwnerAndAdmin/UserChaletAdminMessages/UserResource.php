<?php

namespace App\Http\Resources\OwnerAndAdmin\UserChaletAdminMessages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'account_picture' => url('/') . Storage::url('users/' . $this->account_picture),
            'name' => $this->first_name . ' ' . $this->last_name,
            'fcm_token' => $this->fcm_token,
        ];
    }
}
