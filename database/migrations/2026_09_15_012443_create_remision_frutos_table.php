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
        Schema::create('remision_frutos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->date('fecha');
            $table->integer('remision')->unique();
            $table->foreignId('finca_id')->constrained('fincas')->onDelete('cascade');
            $table->foreignId('destino_id')->constrained('provedores')->onDelete('cascade');
            $table->foreignId('provedore_id')->constrained('provedores')->onDelete('cascade');
            $table->foreignId('conductore_id')->constrained('conductores')->onDelete('cascade');
            $table->string('placa');
            $table->string('firma_conductor')->nullable();
            $table->string('autorizado_por')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remision_frutos');
    }
};
