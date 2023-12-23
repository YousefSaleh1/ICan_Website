<?php

namespace App\Http\Resources;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $photo = new PhotoResource(Photo::where('id',$this->photo_id)->first());
        return [
            'photo_id' => $photo,
        ];
    }
}
