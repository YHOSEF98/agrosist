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
        Schema::create('viaje_frutos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remision_fruto_id')->constrained('remision_frutos')->onDelete('cascade');
            $table->string('ticket', 50)->unique();
            $table->string('ticket_c', 50)->unique();
            $table->integer('peso_bruto');
            $table->integer('tara');
            $table->integer('peso_neto');
            $table->integer('ajuste_calidad');
            $table->integer('peso_final');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viaje_frutos');
    }
};
