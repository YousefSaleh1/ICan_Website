<?php

namespace App\Http\Resources;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $email = Email::where('id',$this->email_id)->first();
        return [
            'id'       => $this->id,
            'email_id' => new EmailResource($email),
            'name'     => $this->name,
            'body'     => $this->body,
        ];
    }
}
