<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
      status is denormalized (set to 'answered' the moment an admin
      posts a reply, in Admin\AnswerController::store) rather than
      computed on the fly — makes the Pending/Answered admin filter a
      simple WHERE instead of a subquery on every listing.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('question_text');
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'answered'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
