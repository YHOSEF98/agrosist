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
        Schema::create('cuadrillas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('nombre');
            $table->foreignId('labore_id')->constrained('labores')->onDelete('cascade');
            $table->string('observacion')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuadrillas');
    }
};
