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
       Schema::create('bookmarks', function (Blueprint $table) {

        $table->id();

        /*
        |--------------------------------------------------------------------------
        | Relationships
        |--------------------------------------------------------------------------
        */

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('question_id')
            ->constrained()
            ->cascadeOnDelete();

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Bookmarks
        |--------------------------------------------------------------------------
        */

        $table->unique([
            'user_id',
            'question_id',
        ]);

        $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
