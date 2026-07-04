<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\AnswerLikeService;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;

class AnswerLikeController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected AnswerLikeService $answerLikeService
    ) {}

    /**
     * Like / Unlike Answer
     */
    public function toggle(
        int $answerId
    ): JsonResponse {

        $result = $this->answerLikeService
            ->toggle($answerId);

        return $this->successResponse(

            data: $result,

            message: $result['liked']
                ? 'Answer liked successfully'
                : 'Answer unliked successfully'
        );
    }
}
