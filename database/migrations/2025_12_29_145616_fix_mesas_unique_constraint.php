<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Cambia la constraint única de ['testigo_id', 'numero_mesa']
     * a ['puesto_id', 'numero_mesa'] para prevenir que múltiples
     * testigos sean asignados a la misma mesa en el mismo puesto.
     */
    public function up(): void
    {
        Schema::table('mesas', function (Blueprint $table) {
            // Eliminar la constraint única actual (testigo_id, numero_mesa)
            $table->dropUnique(['testigo_id', 'numero_mesa']);

            // Agregar la nueva constraint única (puesto_id, numero_mesa)
            // Esto previene que la misma mesa en un puesto sea asignada a múltiples testigos
            $table->unique(['puesto_id', 'numero_mesa'], 'mesas_puesto_numero_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mesas', function (Blueprint $table) {
            // Revertir: eliminar la constraint (puesto_id, numero_mesa)
            $table->dropUnique('mesas_puesto_numero_unique');

            // Restaurar la constraint original (testigo_id, numero_mesa)
            $table->unique(['testigo_id', 'numero_mesa']);
        });
    }
};
