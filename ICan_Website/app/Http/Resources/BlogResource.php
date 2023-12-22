<?php

namespace App\Http\Resources;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $photo = Photo::find($this->photo_id);
        return [
            'id'      => $this->id,
            'photo'   => new PhotoResource($photo),
            'title'   => $this->title,
            'content' => $this->content,
            'update'  => $this->updated_at->format('Y-m-d'),
        ];
    }
}
