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
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('tipo_documento', 6);
            $table->string('numero_documento', 12)->unique();
            $table->date('fecha_ingreso');
            $table->string('email')->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('persona_contacto')->nullable();
            $table->string('telefono_persona_contacto')->nullable();
            $table->foreignId('cargo_id')->constrained('cargos')->onDelete('cascade');
            $table->decimal('salario', 10, 2);
            $table->decimal('aux_transporte', 10, 2)->nullable();
            $table->enum('estatus', ['activo', 'inactivo'])->default('activo');
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadores');
    }
};
