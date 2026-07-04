<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;


class ArticleController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected ArticleService $articleService
    ) {}

    public function index(): JsonResponse
    {
        $articles = $this->articleService
            ->getAllArticles();

        return $this->successResponse(
            data: ArticleResource::collection($articles),
            message: 'Articles fetched successfully',
            meta: [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ]
        );
    }
    public function show(string $slug): JsonResponse
    {
    $article = $this->articleService
    ->getArticleBySlug($slug);

    return $this->successResponse(
        data: new ArticleResource($article),
        message: 'Article fetched successfully'
    );

    }


    public function store(
        StoreArticleRequest $request
    ): JsonResponse {

        $article = $this->articleService
            ->createArticle($request->validated());

        return $this->successResponse(
            data: new ArticleResource($article),
            message: 'Article created successfully',
            status: 201
        );
    }
    public function update(UpdateArticleRequest $request,Article $article): JsonResponse 
    {
         $this->authorize('update', $article);
        $article = $this->articleService  
            ->updateArticle(
                $article,
                $request->validated()
            );

        return $this->successResponse(
            data: new ArticleResource($article),
            message: 'Article updated successfully'
        );  

    }

    public function destroy(Article $article): JsonResponse 
    {

        $this->authorize('delete', $article);
        $this->articleService
            ->deleteArticle($article);

        return $this->successResponse(
            message: 'Article deleted successfully'
        );

    }
}
