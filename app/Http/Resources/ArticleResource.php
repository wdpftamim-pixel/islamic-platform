<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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

            'title' => $this->title,

            'slug' => $this->slug,

            'excerpt' => $this->excerpt,

            'content' => $this->content,

            'thumbnail' => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,

            'is_published' => $this->is_published,

            'is_featured' => $this->is_featured,

            'published_at' => $this->published_at,

            'author' => $this->whenLoaded('author', function () {

                return [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                    'email' => $this->author->email,
                ];
            }),

            'category' => $this->whenLoaded('category', function () {

                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug,
                ];
            }),

            'created_at' => $this->created_at,
        ];
    }
}
