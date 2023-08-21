<?php

namespace App\Http\Resources\User\UserChaletAdminMessages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ChaletsHaveMessagesResource extends JsonResource
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
            'chalet_owner_fcm_token' => $this->chalet_owner_fcm_token,
            'user_chalet_status' => $this->user_chalet_status,
        ];
    }
}
