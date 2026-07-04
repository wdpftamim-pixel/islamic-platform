<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\AnswerService;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Http\Requests\StoreAnswerRequest;
use App\Models\Answer;
use App\Http\Requests\UpdateAnswerRequest;
use Illuminate\Auth\Access\AuthorizationException;

class AnswerController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected AnswerService $answerService
    ) {}

    /**
     * Create answer
     */
    public function store(
        StoreAnswerRequest $request
    ): JsonResponse {

        $answer = $this->answerService
            ->createAnswer(
                $request->validated()
            );

        return $this->successResponse(

            data: new AnswerResource($answer),

            message: 'Answer created successfully',

            status: 201
        );
    }
  public function markBestAnswer(
        int $answerId
        ): JsonResponse {
        $answer = Answer::query()
            ->with('question')
            ->findOrFail($answerId);

        $this->authorize(
            'selectBestAnswer',
            $answer->question
        );

        $answer = $this->answerService
            ->markAsBestAnswer($answerId);

        return $this->successResponse(

            data: new AnswerResource($answer),

            message: 'Best answer selected successfully'
        );

        }
       public function update(
            UpdateAnswerRequest $request,
            Answer $answer
        ): JsonResponse {

            $this->authorize(
                'update',
                $answer
            );

            $answer = $this->answerService
                ->updateAnswer(
                    $answer,
                    $request->validated()
                );

            return $this->successResponse(
                data: new AnswerResource($answer),
                message: 'Answer updated successfully'
            );
        }

            public function destroy(
            Answer $answer
            ): JsonResponse {

            $this->authorize(
                'delete',
                $answer
            );

            $this->answerService
                ->deleteAnswer($answer);

            return $this->successResponse(

                message: 'Answer deleted successfully'
            );

            }



}
