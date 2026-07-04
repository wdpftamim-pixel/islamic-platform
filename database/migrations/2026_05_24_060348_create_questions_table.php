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
       Schema::create('questions', function (Blueprint $table) {

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
        | Categorization
        |--------------------------------------------------------------------------
        */

        $table->foreignId('category_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        /*
        |--------------------------------------------------------------------------
        | Question Content
        |--------------------------------------------------------------------------
        */

        $table->string('title');

        $table->string('slug')
            ->unique();

        $table->text('content');

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        $table->boolean('is_answered')
            ->default(false);

        $table->boolean('is_approved')
            ->default(false);

        $table->boolean('is_featured')
            ->default(false);

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $table->unsignedBigInteger('views_count')
            ->default(0);

        /*
        |--------------------------------------------------------------------------
        | Best Answer
        |--------------------------------------------------------------------------
        */

        $table->unsignedBigInteger('best_answer_id')
            ->nullable();

        $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
