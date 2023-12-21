<?php

namespace App\Http\Resources;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $email = Email::find($this->email_id);
        return [
            'id'    => $this->id,

            'email' => new EmailResource($email),

        ];
    }
}
