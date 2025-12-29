<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar si la tabla 'mesas' existe, si no, lo más probable es que se cree en la migración anterior
        // pero por seguridad, nos aseguramos que estamos listos
        if (Schema::hasTable('testigo') && Schema::hasTable('mesas')) {
            $testigos = DB::table('testigo')->whereNotNull('mesas')->get();

            foreach ($testigos as $testigo) {
                // Verificar si ya existe el registro para evitar duplicados si se corre varias veces
                $exists = DB::table('mesas')
                    ->where('testigo_id', $testigo->id)
                    ->where('numero_mesa', $testigo->mesas)
                    ->exists();

                if (!$exists && $testigo->mesas > 0) {
                    DB::table('mesas')->insert([
                        'testigo_id' => $testigo->id,
                        'puesto_id' => $testigo->fk_id_puesto, // Asumimos que fk_id_puesto es el ID
                        'numero_mesa' => $testigo->mesas,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No borramos los datos en rollback para no perder información
        // Si se quisiera revertir, se podría truncar la tabla mesas si y solo si se quisiera deshacer todo
    }
};
