<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     Saved tips store their OWN copy of title/image/description rather
     than just a foreign key to `tips` — per the spec, a saved tip must
     stay accessible even if the admin later deletes the original. The
     image is physically copied to a separate folder at save-time too
     (see SavedTipController::store) so it survives the original being
     deleted from disk.
     */
    public function up(): void
    {
        Schema::create('save_tips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Reference only — intentionally NOT a foreign key constraint,
            // since the original tip may be deleted while this record
            // (and its snapshot data below) lives on.
            $table->unsignedBigInteger('original_tip_id')->nullable();

            $table->string('title');
            $table->string('image')->nullable();
            $table->text('description');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('save_tips');
    }
};
