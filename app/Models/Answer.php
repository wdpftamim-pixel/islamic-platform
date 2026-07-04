<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    protected $fillable = [

        'user_id',

        'question_id',

        'content',

        'is_approved',

        'is_best_answer',

        'likes_count',

        'approved_at',
    ];

    protected $casts = [

        'is_approved' => 'boolean',

        'is_best_answer' => 'boolean',

        'approved_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
    public function likes(): HasMany
    {
    return $this->hasMany(
    AnswerLike::class
    );
    }

}
