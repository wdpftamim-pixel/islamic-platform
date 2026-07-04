<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;

class LeaderboardController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $users = User::query()

            ->select([
                'id',
                'name',
                'reputation',
            ])

            ->orderByDesc('reputation')

            ->limit(20)

            ->get();

        return $this->successResponse(

            data: $users,

            message: 'Leaderboard fetched successfully'
        );
    }
}
