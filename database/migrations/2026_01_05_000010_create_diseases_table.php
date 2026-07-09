<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     created_at doubles as "publication date" and updated_at as
     "last updated date" per the spec — no need for separate columns.
    */
    public function up(): void
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('affected_crop');
            $table->string('image');
            $table->enum('warning_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->text('symptoms');
            $table->text('preventive_measures');
            $table->text('suggested_treatments');
            $table->text('additional_recommendations')->nullable();

            // Which admin published this. Nullable + set-null-on-delete so
            // removing an admin account never cascades into deleting the
            // disease records they published.
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diseases');
    }
};
