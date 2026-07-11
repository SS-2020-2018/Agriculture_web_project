<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     Pivot table for the Tip <-> User "likes" many-to-many relationship.
     The unique constraint is what actually prevents duplicate likes at
     the database level, on top of the application-level check.
     */
    public function up(): void
    {
        Schema::create('tip_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tip_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['tip_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tip_likes');
    }
};
