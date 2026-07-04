<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

class QuestionPolicy
{
    /**
     * Update Question
     */
    public function update(
        User $user,
        Question $question
    ): bool {

        return $user->id === $question->user_id
            || $user->hasRole([
                'super-admin',
                'admin',
            ]);
    }

    /**
     * Delete Question
     */
    public function delete(
        User $user,
        Question $question
    ): bool {

        return $user->id === $question->user_id
            || $user->hasRole([
                'super-admin',
                'admin',
            ]);
    }

    /**
     * Select Best Answer
     */
    public function selectBestAnswer(
        User $user,
        Question $question
    ): bool {

        return $user->id === $question->user_id
            || $user->hasRole([
                'super-admin',
                'admin',
            ]);
    }
}
