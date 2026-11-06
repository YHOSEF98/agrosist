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
        Schema::create('conductores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provedore_id')->constrained('provedores')->onDelete('cascade');
            $table->foreignId('tipo_documento_id')->constrained('tipos_documentos')->onDelete('cascade');
            $table->integer('numero_documento');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('placa', 8);
            $table->string('telefono', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductores');
    }
};
