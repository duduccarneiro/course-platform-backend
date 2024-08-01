<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->hashid,
            'name' => $this->name,
            'slug' => $this->slug,
            $this->mergeWhen( !$this->parent_id, [
                'children' => static::collection($this->whenLoaded('children'))
            ])
        ];
    }
}
