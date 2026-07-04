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
      Schema::create('answer_likes', function (Blueprint $table) {

        $table->id();

        /*
        |--------------------------------------------------------------------------
        | Relationships
        |--------------------------------------------------------------------------
        */

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('answer_id')
            ->constrained()
            ->cascadeOnDelete();

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Likes
        |--------------------------------------------------------------------------
        */

        $table->unique([
            'user_id',
            'answer_id',
        ]);

        $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_likes');
    }
};
