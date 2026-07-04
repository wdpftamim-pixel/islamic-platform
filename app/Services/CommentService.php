<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\NewCommentNotification;
use App\Events\CommentCreated;



class CommentService
{
    public function getArticleComments(
        int $articleId
    ): Collection {

        return Comment::query()

            ->with([
                'user',
                'replies.user',
            ])

            ->where('article_id', $articleId)

            ->whereNull('parent_id')

            ->where('is_approved', true)

            ->latest()

            ->get();
    }

    public function createComment(array $data): Comment 
    {
        $comment = Comment::query()->create([
            ...$data,
            'user_id' => auth()->id(),
            'is_approved' => true,
        ]);

        $comment->load([
        'user',
        'article.author',
        ]);

       CommentCreated::dispatch($comment);  

        return $comment;
    }

}
