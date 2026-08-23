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
        Schema::create('cuadrilla_trabajador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuadrilla_id')->constrained('cuadrillas')->onDelete('cascade');
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->date('fecha');
            $table->timestamps();

            // Restricción única: un trabajador no puede estar en dos cuadrillas el mismo día
            $table->unique(['trabajador_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuadrilla_trabajador');
    }
};
