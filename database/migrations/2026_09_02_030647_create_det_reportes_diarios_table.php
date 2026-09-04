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
        Schema::create('det_reportes_diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_diario_id')->constrained('reportes_diarios')->onDelete('cascade');
            $table->foreignId('acopios_id')->constrained('acopios')->onDelete('cascade')->nullable();
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');
            $table->string('lineas')->nullable();
            $table->string('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('det_reportes_diarios');
    }
};
