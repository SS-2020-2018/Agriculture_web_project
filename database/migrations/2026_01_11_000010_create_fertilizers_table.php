<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
      A single record covers a crop's full fertilizer recommendation.
      When multiple fertilizers apply (e.g. Urea + TSP + DAP), they're
      kept together as one comma-separated `fertilizers` field alongside
      one holistic `quantity` description — see Fertilizer model for the
      reasoning behind not normalizing this into a separate line-items
      table.
     */
    public function up(): void
    {
        Schema::create('fertilizers', function (Blueprint $table) {
            $table->id();
            $table->string('crop_name');
            $table->string('crop_image')->nullable();
            $table->string('fertilizers'); // e.g. "Urea, TSP, DAP, MOP"
            $table->string('application_stage');
            $table->string('quantity'); // e.g. "Urea 50kg, TSP 30kg per acre"
            $table->string('application_method');
            $table->text('usage_instructions');
            $table->text('additional_notes')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fertilizers');
    }
};
