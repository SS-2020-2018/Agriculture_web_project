<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
      crop_image is nullable — unlike Diseases/Tips, price records get
     added repeatedly for the same crop as prices change day to day, so
      requiring a fresh photo upload every single time would be tedious.
      The view falls back to a generic crop icon when it's missing.
     */
    public function up(): void
    {
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->string('crop_name');
            $table->string('crop_image')->nullable();
            $table->string('market_name');
            $table->decimal('price_per_unit', 10, 2);
            $table->string('unit')->default('kg'); // kg, sack, ton, maund, etc.
            $table->text('remarks')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_prices');
    }
};
