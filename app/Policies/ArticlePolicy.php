<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function update(
        User $user,
        Article $article
    ): bool {

        if ($user->hasAnyRole([
            'super-admin',
            'admin',
        ])) {
            return true;
        }

        return $article->user_id === $user->id;
    }

    public function delete(
        User $user,
        Article $article
    ): bool {

        if ($user->hasAnyRole([
            'super-admin',
            'admin',
        ])) {
            return true;
        }

        return $article->user_id === $user->id;
    }
}
