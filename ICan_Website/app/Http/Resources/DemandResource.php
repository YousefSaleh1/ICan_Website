<?php

namespace App\Http\Resources;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandResource extends JsonResource
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
            'id'               => $this->id,
            'email'            => new EmailResource($email),
            'serviece_name'    => $this->serviece_name,
            'serviece_details' => $this->serviece_details
        ];
    }
}
