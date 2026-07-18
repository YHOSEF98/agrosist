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
        Schema::create('frutas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acopio_id')->constrained('acopios')->onDelete('cascade');
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');
            $table->float('cant_racimos');
            $table->dateTime('fecha_cosecha')->nullable();
            $table->float('peso_aprox')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frutas');
    }
};
