<?php

use App\Models\UnidadMedida;
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
        Schema::create('labores', function (Blueprint $table) {
            $table->id();
            $table->string('actividad');
            $table->foreignId('unidad_medida_id')->constrained('unidad_medidas')->onDelete('cascade'); // Hombre/día, bulto, palma, etc.
            $table->decimal('rendimiento_esperado',6,2);
            $table->decimal('valor_unitario', 12, 2);
            $table->decimal('tarifa_contratista', 12, 2)->nullable();
            $table->decimal('tarifa_personal_directo', 12, 2)->nullable();
            $table->decimal('valor_prestaciones', 12, 2)->nullable();
            $table->decimal('valor_total', 12, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

     

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labores');
    }
};
