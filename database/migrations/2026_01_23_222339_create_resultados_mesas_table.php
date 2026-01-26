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
        Schema::create('resultados_mesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesa_id')->constrained('mesas')->onDelete('cascade');
            $table->foreignId('testigo_id')->constrained('testigo')->onDelete('cascade');
            $table->string('imagen_acta')->nullable();
            $table->text('observacion')->nullable();
            $table->integer('total_votos')->nullable();
            $table->enum('estado', ['pendiente', 'enviado', 'validado'])->default('pendiente');
            $table->timestamps();

            $table->unique('mesa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados_mesas');
    }
};
