<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\AnswerLikeController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\LeaderboardController;





/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/articles',
    [ArticleController::class, 'index']
);

Route::get(
    '/articles/{slug}',
    [ArticleController::class, 'show']
);

Route::get(
    '/articles/{articleId}/comments',
    [CommentController::class, 'index']
);
Route::get(
'/questions',
[QuestionController::class, 'index']
);

Route::get(
    '/users/{userId}',
    [UserProfileController::class, 'show']
);
Route::get(
    '/leaderboard',
    [LeaderboardController::class, 'index']
);


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

  Route::post('/comments',[CommentController::class, 'store'])->middleware('throttle:comments');
  Route::post('/questions',[QuestionController::class, 'store']);
  Route::post('/answers',[AnswerController::class, 'store']);
  Route::get('/questions/{slug}',[QuestionController::class, 'show']);
  Route::patch('/answers/{answerId}/best',[AnswerController::class, 'markBestAnswer']);
  Route::post('/questions/{questionId}/bookmark',[BookmarkController::class, 'toggle']);
  Route::get('/my-bookmarks',[BookmarkController::class, 'index']);
  Route::post('/answers/{answerId}/like',[AnswerLikeController::class, 'toggle']);
  Route::patch('/answers/{answer}',[AnswerController::class, 'update']);
  Route::delete('/answers/{answer}',[AnswerController::class, 'destroy']);



});





/*
|--------------------------------------------------------------------------
| Admin / Author Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    'role:super-admin|admin|editor|author'
])->group(function () {

    Route::post(
        '/articles',
        [ArticleController::class, 'store']
    );

    Route::put(
        '/articles/{article}',
        [ArticleController::class, 'update']
    );

    Route::delete(
        '/articles/{article}',
        [ArticleController::class, 'destroy']
    );

});
