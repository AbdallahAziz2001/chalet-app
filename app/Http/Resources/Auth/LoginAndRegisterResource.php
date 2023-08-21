<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LoginAndRegisterResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'balance' => floatval($this->balance),
            'account_picture' => url('/') . Storage::url('users/' . $this->account_picture),
            'token' => $this->token,
            'fcm_token' => $this->fcm_token,
        ];
    }
}
