<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('image'); // required — path in storage/app/public
            $table->date('planting_date');
            $table->date('expected_harvest_date');
            $table->string('land_area'); // free text, e.g. "2 Bigha", "1.5 Acres"
            $table->enum('status', ['growing', 'ready_for_harvest', 'harvested'])->default('growing');
            $table->text('description')->nullable();

            // Admin feedback 
            $table->text('admin_feedback')->nullable();
            $table->timestamp('admin_feedback_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};
