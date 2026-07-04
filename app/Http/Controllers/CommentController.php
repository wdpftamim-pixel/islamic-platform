<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected CommentService $commentService
    ) {}

    public function index(
        int $articleId
    ): JsonResponse {

        $comments = $this->commentService
            ->getArticleComments($articleId);

        return $this->successResponse(
            data: CommentResource::collection($comments),
            message: 'Comments fetched successfully'
        );
    }

    public function store(StoreCommentRequest $request): JsonResponse 
    {
        $comment = $this->commentService
            ->createComment(
                $request->validated()
            );

        $comment->load([
            'user',
            'replies.user',
        ]);

        return $this->successResponse(
            data: new CommentResource($comment),
            message: 'Comment created successfully',
            status: 201
        );

    }

}
