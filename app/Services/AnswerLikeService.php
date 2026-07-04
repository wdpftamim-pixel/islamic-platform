<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\AnswerLike;

class AnswerLikeService
{
    /**
     * Toggle like
     */
    public function toggle(
        int $answerId
    ): array {

        $userId = auth()->id();

        $like = AnswerLike::query()

            ->where('user_id', $userId)

            ->where('answer_id', $answerId)

            ->first();

        $answer = Answer::query()
            ->findOrFail($answerId);

        /*
        |--------------------------------------------------------------------------
        | Unlike
        |--------------------------------------------------------------------------
        */

        if ($like) {

            $like->delete();

            $answer->decrement(
                'likes_count'
            );

            return [
                'liked' => false,
                'likes_count' => $answer->fresh()->likes_count,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Like
        |--------------------------------------------------------------------------
        */

        AnswerLike::query()->create([

            'user_id' => $userId,

            'answer_id' => $answerId,

        ]);

        $answer->increment(
            'likes_count'
        );

        return [
            'liked' => true,
            'likes_count' => $answer->fresh()->likes_count,
        ];
    }
}
