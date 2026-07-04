<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

class AnswerPolicy
{
    /**
     * Update Answer
     */
    public function update(
        User $user,
        Answer $answer
    ): bool {

        return $user->id === $answer->user_id
            || $user->hasRole([
                'super-admin',
                'admin',
            ]);
    }

    /**
     * Delete Answer
     */
    public function delete(
        User $user,
        Answer $answer
    ): bool {

        return $user->id === $answer->user_id
            || $user->hasRole([
                'super-admin',
                'admin',
            ]);
    }
}
