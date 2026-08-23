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
        Schema::create('pluviometrias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('pluviometro_id')->references('id')->on('pluviometros')->onDelete('cascade');
            $table->decimal('cantidad', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pluviometrias');
    }
};
