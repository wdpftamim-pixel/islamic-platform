<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;


class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Comment $comment
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [

            'comment_id' => $this->comment->id,

            'article_id' => $this->comment->article_id,

            'article_title' => $this->comment
                ->article
                ->title,

            'comment_user' => $this->comment
                ->user
                ->name,

            'message' => 'New comment added to your article.',
        ];
    }
}
