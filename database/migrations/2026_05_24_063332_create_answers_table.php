<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('answers', function (Blueprint $table) {

        $table->id();

        /*
        |--------------------------------------------------------------------------
        | Ownership
        |--------------------------------------------------------------------------
        */

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        /*
        |--------------------------------------------------------------------------
        | Question Relationship
        |--------------------------------------------------------------------------
        */

        $table->foreignId('question_id')
            ->constrained()
            ->cascadeOnDelete();

        /*
        |--------------------------------------------------------------------------
        | Answer Content
        |--------------------------------------------------------------------------
        */

        $table->longText('content');

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        $table->boolean('is_approved')
            ->default(false);

        $table->boolean('is_best_answer')
            ->default(false);

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $table->unsignedBigInteger('likes_count')
            ->default(0);

        /*
        |--------------------------------------------------------------------------
        | Moderation / Publishing
        |--------------------------------------------------------------------------
        */

        $table->timestamp('approved_at')
            ->nullable();

        $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
