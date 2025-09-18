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
        Schema::create('infoelectoral', function (Blueprint $table) {
            $table->id();
            $table->string('id_zona', 20);
            $table->string('id_puesto', 20);
            $table->string('direccion', 20);
            $table->string('mesa_vota', 20);
            $table->integer('fk_id_testigo');
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index('id_zona');
            $table->index('id_puesto');
            $table->index('fk_id_testigo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infoelectoral');
    }
};