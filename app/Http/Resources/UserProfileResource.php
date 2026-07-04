<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function toArray(
        Request $request
    ): array {

        return [

            'id' => $this->id,

            'name' => $this->name,

            'email' => $this->email,
            
            'reputation' => $this->reputation,

            'questions_count' => $this->questions_count,

            'answers_count' => $this->answers_count,

            'bookmarks_count' => $this->bookmarks_count,

            'likes_received' => $this->likes_received,

            'created_at' => $this->created_at,
        ];
    }
}
