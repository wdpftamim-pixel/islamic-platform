<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;

class UserProfileController extends Controller
{
    use ApiResponseTrait;

    public function show(
        int $userId
    ): JsonResponse {

        $user = User::query()

            ->withCount([
                'questions',
                'answers',
                'bookmarks',
            ])

            ->findOrFail($userId);

        /*
        |--------------------------------------------------------------------------
        | Likes Received
        |--------------------------------------------------------------------------
        */

        $likesReceived = $user
            ->answers()
            ->sum('likes_count');

        $user->likes_received = $likesReceived;

        return $this->successResponse(

            data: new UserProfileResource(
                $user
            ),

            message: 'Profile fetched successfully'
        );
    }
}
