<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Añadir eleccion_id si aún no existe
        if (!Schema::hasColumn('resultados_mesas', 'eleccion_id')) {
            Schema::table('resultados_mesas', function (Blueprint $table) {
                $table->unsignedBigInteger('eleccion_id')->nullable()->after('mesa_id');
                $table->foreign('eleccion_id')->references('id')->on('elecciones')->nullOnDelete();
            });
        }

        // Asignar eleccion_id a registros existentes
        $primeraEleccion = DB::table('elecciones')->orderBy('id')->value('id');
        if ($primeraEleccion) {
            DB::table('resultados_mesas')
                ->whereNull('eleccion_id')
                ->update(['eleccion_id' => $primeraEleccion]);
        }

        // Quitar FK de mesa_id para poder eliminar el índice único
        Schema::table('resultados_mesas', function (Blueprint $table) {
            $table->dropForeign(['mesa_id']);
        });

        // Quitar índice único en mesa_id
        Schema::table('resultados_mesas', function (Blueprint $table) {
            $table->dropUnique(['mesa_id']);
        });

        // Recrear FK + índice regular en mesa_id, y crear índice único compuesto
        Schema::table('resultados_mesas', function (Blueprint $table) {
            $table->foreign('mesa_id')->references('id')->on('mesas')->cascadeOnDelete();
            $table->unique(['mesa_id', 'eleccion_id']);
        });
    }

    public function down(): void
    {
        Schema::table('resultados_mesas', function (Blueprint $table) {
            $table->dropUnique(['mesa_id', 'eleccion_id']);
            $table->dropForeign(['mesa_id']);
            $table->dropForeign(['eleccion_id']);
            $table->dropColumn('eleccion_id');
        });
        Schema::table('resultados_mesas', function (Blueprint $table) {
            $table->foreign('mesa_id')->references('id')->on('mesas')->cascadeOnDelete();
            $table->unique(['mesa_id']);
        });
    }
};
