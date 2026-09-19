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
        Schema::create('invfrutas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('reporte_id')->constrained('reportes_diarios')->onDelete('cascade');
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');
            $table->foreignId('acopio_id')->constrained('acopios')->onDelete('cascade');
            $table->integer('cantidad');
            $table->integer('cantidad_cargada')->default(0);
            $table->boolean('cargado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invfrutas');
    }
};
