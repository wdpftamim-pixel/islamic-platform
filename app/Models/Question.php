<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Question extends Model
{
    protected $fillable = [

        'user_id',
        'category_id',

        'title',
        'slug',
        'content',

        'is_answered',
        'is_approved',
        'is_featured',

        'views_count',

        'best_answer_id',
    ];

    protected $casts = [

        'is_answered' => 'boolean',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function answers(): HasMany
    {
    return $this->hasMany(Answer::class);
    }

    public function bestAnswer(): BelongsTo
    {
    return $this->belongsTo(
    Answer::class,
    'best_answer_id'
    );
    }
    public function bookmarks(): HasMany
    {
    return $this->hasMany(Bookmark::class);
    }


}
