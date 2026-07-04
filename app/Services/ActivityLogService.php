<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    public function log(
        string $action,
        ?Model $subject = null,
        array $properties = []
    ): void {

        ActivityLog::query()->create([

            'user_id' => auth()->id(),

            'action' => $action,

            'subject_type' => $subject
                ? $subject::class
                : null,

            'subject_id' => $subject?->id,

            'properties' => $properties,

        ]);
    }
}
