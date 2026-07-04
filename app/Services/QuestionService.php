<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class QuestionService
{
   public function getQuestions(array $filters = []): LengthAwarePaginator {

    return Question::query()
            ->with([
                'user',
                'category',
                'bestAnswer.user',
            ])

            ->where('is_approved', true)

            ->when(
                $filters['search'] ?? null,
                function ($query, $search) {

                    $query->where(function ($query) use ($search) {

                        $query->where(
                            'title',
                            'ILIKE',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'content',
                            'ILIKE',
                            "%{$search}%"
                        );

                    });

                }
            )

            ->when(
                isset($filters['answered']),
                fn ($query) => $query->where(
                    'is_answered',
                    filter_var(
                        $filters['answered'],
                        FILTER_VALIDATE_BOOLEAN
                    )
                )
            )

            ->when(
                isset($filters['featured']),
                fn ($query) => $query->where(
                    'is_featured',
                    filter_var(
                        $filters['featured'],
                        FILTER_VALIDATE_BOOLEAN
                    )
                )
            )

            ->when(
                $filters['category_id'] ?? null,
                fn ($query, $categoryId) => $query->where(
                    'category_id',
                    $categoryId
                )
            )

            ->latest()

            ->paginate(10);


    }


    public function createQuestion(
        array $data
    ): Question {

        $question = Question::query()->create([

            'user_id' => auth()->id(),

            'category_id' => $data['category_id'] ?? null,

            'title' => $data['title'],

            'slug' => Str::slug($data['title'])
                . '-'
                . time(),

            'content' => $data['content'],

            'is_approved' => true,

        ]);

       return $question
        ->fresh()
        ->load([
        'user',
        'category',
        ]);

    }
    public function getQuestionBySlug(
    string $slug
    ): Question {

    $question = Question::query()

        ->with([

            'user',

            'category',

            'answers.user',

            'bestAnswer.user',

        ])

        ->where('slug', $slug)

        ->where('is_approved', true)

        ->first();

    if (! $question) {

        throw new ModelNotFoundException(
            'Question not found'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Increment Views
    |--------------------------------------------------------------------------
    */

    $question->increment('views_count');

    return $question->fresh([
        'user',
        'category',
        'answers.user',
        'bestAnswer.user',
    ]);

    }

}
