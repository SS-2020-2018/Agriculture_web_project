<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
      Pivot table for the Answer <-> User "likes" many-to-many
      relationship — same pattern as tip_likes from Phase 8.
     */
    public function up(): void
    {
        Schema::create('answer_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['answer_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answer_likes');
    }
};
