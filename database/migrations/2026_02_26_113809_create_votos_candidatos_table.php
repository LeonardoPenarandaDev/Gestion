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
        Schema::create('votos_candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resultado_mesa_id')->constrained('resultados_mesas')->onDelete('cascade');
            $table->foreignId('candidato_id')->constrained('candidatos')->onDelete('cascade');
            $table->integer('votos')->default(0);
            $table->timestamps();
            $table->unique(['resultado_mesa_id', 'candidato_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votos_candidatos');
    }
};
