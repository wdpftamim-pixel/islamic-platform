<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Services\QuestionService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Question;
use Illuminate\Http\Request;


class QuestionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected QuestionService $questionService
    ) {}

    /**
     * Question listing
     */
    public function index(Request $request): JsonResponse
    {
        $questions = $this->questionService->getQuestions($request->only(['search','answered','featured','category_id',]));



        return $this->successResponse(

            data: QuestionResource::collection($questions),

            message: 'Questions fetched successfully',

            meta: [

                'current_page' => $questions->currentPage(),

                'last_page' => $questions->lastPage(),

                'per_page' => $questions->perPage(),

                'total' => $questions->total(),

            ]
        );
    }

    /**
     * Create question
     */
    public function store(
        StoreQuestionRequest $request
    ): JsonResponse {

        $question = $this->questionService
            ->createQuestion(
                $request->validated()
            );

        return $this->successResponse(

            data: new QuestionResource($question),

            message: 'Question created successfully',

            status: 201
        );
    }
    public function show(
    string $slug
    ): JsonResponse {

    $question = $this->questionService
        ->getQuestionBySlug($slug);

    return $this->successResponse(

        data: new QuestionResource($question),

        message: 'Question fetched successfully'
    );


    }

}
