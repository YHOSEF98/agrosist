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
        Schema::create('detalle_viajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viaje_fruto_id')->constrained('viaje_frutos')->onDelete('cascade');
            $table->foreignId('det_viaje_fruto_id')->constrained('det_viaje_frutos')->onDelete('cascade')->unique();
            $table->decimal('promedio', 10,2);
            $table->decimal('peso_neto', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_viajes');
    }
};
