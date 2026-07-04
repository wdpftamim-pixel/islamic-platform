<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class ArticleService
{
   public function getAllArticles(): LengthAwarePaginator
    {
    return Article::query()
        ->where('is_published', true)
        ->with([
            'author',
            'category',
        ])

        ->when(request('search'), function ($query) {

            $query->where(function ($q) {

                $q->where('title', 'ilike', '%' . request('search') . '%')
                ->orWhere('content', 'ilike', '%' . request('search') . '%');

            });

        })

        ->when(request('category'), function ($query) {

            $query->whereHas('category', function ($q) {

                $q->where('slug', request('category'));

            });

        })

        ->when(request()->has('featured'), function ($query) {

            $query->where(
                'is_featured',
                request('featured')
            );

        })

        ->latest()

        ->paginate(10)

        ->withQueryString();

    }

    public function getArticleBySlug(string $slug): Article
    {
    return Article::query()
    ->with([
    'author',
    'category',
    ])
    ->where('is_published', true)
    ->where('slug', $slug)
    ->firstOrFail();
    }


    public function createArticle(array $data): Article
    {
        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = $data['thumbnail']
                ->store('articles', 'public');
        }
        return Article::query()->create([
            ...$data,
            'user_id' => auth()->id(),
        ]);

    }

    public function updateArticle(Article $article,array $data): Article 
    {
        $article->update($data);

        return $article->load([
            'author',
            'category',
        ]);


    }

    public function deleteArticle(Article $article): void 
    {

        $article->delete();

    }

}
