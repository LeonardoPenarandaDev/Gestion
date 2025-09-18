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
        Schema::create('testigo', function (Blueprint $table) {
            $table->id();
            $table->string('fk_id_zona', 2);
            $table->string('fk_id_puesto', 2);
            $table->integer('mesas')->nullable();
            $table->string('alias', 20)->nullable();
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index('fk_id_zona');
            $table->index('fk_id_puesto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testigo');
    }
};