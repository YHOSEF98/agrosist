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
        Schema::create('det_viaje_frutos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remision_fruto_id')->constrained('remision_frutos')->onDelete('cascade');
            $table->foreignId('invfrutas_id')->constrained('invfrutas')->onDelete('cascade');
            $table->integer('cantidad_cargada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('det_viaje_frutos');
    }
};
