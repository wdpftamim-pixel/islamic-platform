<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\BookmarkService;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;

class BookmarkController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected BookmarkService $bookmarkService
    ) {}

    /**
     * Save / Unsave Question
     */
    public function toggle(
        int $questionId
    ): JsonResponse {

        $result = $this->bookmarkService
            ->toggle($questionId);

        return $this->successResponse(

            data: $result,

            message: $result['bookmarked']
                ? 'Question bookmarked successfully'
                : 'Bookmark removed successfully'
        );
    }

    /**
     * My saved questions
     */
    public function index(): JsonResponse
    {
        $questions = $this->bookmarkService
            ->myBookmarks();

        return $this->successResponse(

            data: QuestionResource::collection(
                $questions
            ),

            message: 'Bookmarks fetched successfully'
        );
    }
}
