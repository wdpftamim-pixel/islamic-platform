<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class BookmarkService
{
    /**
     * Toggle bookmark
     */
    public function toggle(
        int $questionId
    ): array {

        $userId = auth()->id();

        $bookmark = Bookmark::query()

            ->where('user_id', $userId)

            ->where('question_id', $questionId)

            ->first();

        if ($bookmark) {

            $bookmark->delete();

            return [
                'bookmarked' => false,
            ];
        }

        Bookmark::query()->create([

            'user_id' => $userId,

            'question_id' => $questionId,

        ]);

        return [
            'bookmarked' => true,
        ];
    }

    /**
     * My saved questions
     */
    public function myBookmarks(): Collection
    {
        return Question::query()

            ->whereHas('bookmarks', function ($query) {

                $query->where(
                    'user_id',
                    auth()->id()
                );

            })

            ->with([
                'user',
                'category',
            ])

            ->latest()

            ->get();
    }
}
