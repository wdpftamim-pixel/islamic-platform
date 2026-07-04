<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(
        Request $request
    ): array {

        return [

            'id' => $this->id,

            'content' => $this->content,

            'is_approved' => $this->is_approved,

            'is_best_answer' => $this->is_best_answer,

            'likes_count' => $this->likes_count,

            'approved_at' => $this->approved_at,

            'user' => [

                'id' => $this->user?->id,

                'name' => $this->user?->name,

            ],

            'question' => [

                'id' => $this->question?->id,

                'title' => $this->question?->title,

                'slug' => $this->question?->slug,

            ],

            'created_at' => $this->created_at,

        ];
    }
}
