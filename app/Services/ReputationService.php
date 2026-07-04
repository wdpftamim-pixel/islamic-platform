<?php

namespace App\Services;

use App\Models\User;

class ReputationService
{
    public function recalculate(
        User $user
    ): int {

        $questionsScore =
            $user->questions()->count() * 2;

        $answersScore =
            $user->answers()->count() * 5;

        $bestAnswersScore =
            $user->answers()
                ->where('is_best_answer', true)
                ->count() * 10;

        $likesScore =
            $user->answers()
                ->sum('likes_count');

        $reputation =
            $questionsScore
            + $answersScore
            + $bestAnswersScore
            + $likesScore;

        $user->reputation = $reputation;
        $user->save();

        return $reputation;
    }
}