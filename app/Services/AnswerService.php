<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;



class AnswerService
{
    /**
     * Create answer
     */
    public function createAnswer(
        array $data
    ): Answer {

        $answer = Answer::query()->create([

            'user_id' => auth()->id(),

            'question_id' => $data['question_id'],

            'content' => $data['content'],

            'is_approved' => true,

            'approved_at' => now(),

        ]);

        /*
        |--------------------------------------------------------------------------
        | Mark Question Answered
        |--------------------------------------------------------------------------
        */

        Question::query()
            ->where('id', $data['question_id'])
            ->update([
                'is_answered' => true,
            ]);

        return $answer
            ->fresh()
            ->load([
                'user',
                'question',
            ]);
    }
    public function markAsBestAnswer(
    int $answerId
    ): Answer {

    $answer = Answer::query()
        ->with('question')
        ->findOrFail($answerId);

    /*
    |--------------------------------------------------------------------------
    | Remove Previous Best Answer
    |--------------------------------------------------------------------------
    */

    Answer::query()

        ->where(
            'question_id',
            $answer->question_id
        )

        ->update([
            'is_best_answer' => false,
        ]);

    /*
    |--------------------------------------------------------------------------
    | Mark Current Answer
    |--------------------------------------------------------------------------
    */

    $answer->update([
        'is_best_answer' => true,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Update Question
    |--------------------------------------------------------------------------
    */

    Question::query()

        ->where(
            'id',
            $answer->question_id
        )

        ->update([

            'best_answer_id' => $answer->id,

            'is_answered' => true,

        ]);

    return $answer
        ->fresh()
        ->load([
            'user',
            'question',
        ]);


    }
    public function updateAnswer(
        Answer $answer,
        array $data
        ): Answer {

        $answer->update([
            'content' => $data['content'],
        ]);

        return $answer->fresh([
            'user',
            'question',
        ]);

        }

        public function deleteAnswer(
        Answer $answer
        ): void {

        $answer->delete();

        }


}
