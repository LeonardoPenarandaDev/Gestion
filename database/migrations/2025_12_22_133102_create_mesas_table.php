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
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testigo_id')->constrained('testigo')->onDelete('cascade');
            $table->foreignId('puesto_id')->constrained('puesto')->onDelete('cascade');
            $table->integer('numero_mesa');
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index('testigo_id');
            $table->index('puesto_id');
            
            // Un testigo no puede tener la misma mesa duplicada
            $table->unique(['testigo_id', 'numero_mesa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
