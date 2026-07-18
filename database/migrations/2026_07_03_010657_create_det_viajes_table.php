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
        Schema::create('det_viajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viaje_id')->constrained('viajes_frutas')->onDelete('cascade');
            $table->foreignId('fruta_id')->constrained('frutas')->onDelete('cascade');
            $table->float('racimos');
            $table->float('peso_promedio');
            $table->float('peso_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('det_viajes');
    }
};
