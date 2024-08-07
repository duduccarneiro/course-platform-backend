<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'slug' => $this->slug,
            'status' => $this->isPublished() ? 'Published': 'Draft',
            'published' => $this->isPublished(),
            'level' => $this->level,
            'price' => $this->price,
            'price_formatted' => $this->price_formatted,
            'cover' => $this->cover_image_url,
            $this->mergeWhen($this->relationLoaded('author'), [
                'author' => [
                    'id' => $this->author->hashid,
                    'name' => $this->author->name
                ]
            ]),
            $this->mergeWhen($this->relationLoaded('category'), [
                'category' => [
                    'id' => $this->category->hashid,
                    'name' => $this->category->name
                ],
                'subcategory' => [
                    'id' => $this->subcategory->hashid,
                    'name' => $this->subcategory->name
                ]
            ])
        ];
    }
}
