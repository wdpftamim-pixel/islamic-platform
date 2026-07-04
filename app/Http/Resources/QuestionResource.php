<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AnswerResource;


class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(
        Request $request
    ): array {

        return [

            'id' => $this->id,

            'title' => $this->title,

            'slug' => $this->slug,

            'content' => $this->content,

            'is_answered' => $this->is_answered,

            'is_approved' => $this->is_approved,

            'is_featured' => $this->is_featured,

            'views_count' => $this->views_count,

            'user' => [

                'id' => $this->user?->id,

                'name' => $this->user?->name,

            ],

            'category' => $this->category
                ? [

                    'id' => $this->category->id,

                    'name' => $this->category->name,

                    'slug' => $this->category->slug,

                ]
                : null,
                'best_answer' => $this->bestAnswer
                ? new AnswerResource($this->bestAnswer)
                : null,

                'answers' => AnswerResource::collection(
                $this->whenLoaded('answers')
                ),


            'created_at' => $this->created_at,

        ];
    }
}
