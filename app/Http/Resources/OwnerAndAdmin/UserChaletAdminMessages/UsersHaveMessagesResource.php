<?php

namespace App\Http\Resources\OwnerAndAdmin\UserChaletAdminMessages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UsersHaveMessagesResource extends JsonResource
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
            'name' => $this->first_name . ' ' . $this->last_name,
            'account_picture' => url('/') . Storage::url('users/' . $this->account_picture),
            'fcm_token' => $this->fcm_token,
        ];
    }
}
