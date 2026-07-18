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
        Schema::create('viajes_frutas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('destino');
            $table->string('ticket');
            $table->string('peso_total');
            $table->foreignId('finca_id')->constrained('fincas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes_frutas');
    }
};
