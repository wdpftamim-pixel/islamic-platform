<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\NewCommentNotification;
use App\Services\ActivityLogService;

class SendCommentNotification
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(
        CommentCreated $event
    ): void {

        $comment = $event->comment;

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogService->log(

            action: 'comment_created',

            subject: $comment,

            properties: [

                'article_id' => $comment->article_id,

                'comment_content' => $comment->content,

            ]

        );

        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        if (
            $comment->article->user_id !== $comment->user_id
        ) {

            $comment->article->author
                ->notify(
                    new NewCommentNotification($comment)
                );
        }
    }
}
