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
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('max_fine', 10, 2)->nullable();
            $table->timestamps();
        });

        // Insert default fine configuration
        Schema::table('fines', function (Blueprint $table) {
            // This will be seeded with default values
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
