<?php

namespace App\Http\Resources\OwnerAndAdmin\UserChaletAdminMessages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserChaletsAdminMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->deleted_at != null) {
            $message = 'This Message was Deleted';
        } else {
            $message = $this->message;
        }

        return [
            'id' => $this->id,
            'message' => $message,
            'message_by' => $this->message_by,
            'created_at' => $this->created_at,
        ];
    }
}
