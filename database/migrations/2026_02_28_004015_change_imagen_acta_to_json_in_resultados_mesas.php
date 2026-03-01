<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convertir valores existentes (string) a JSON array antes de cambiar el tipo
        DB::statement("
            UPDATE resultados_mesas
            SET imagen_acta = JSON_ARRAY(imagen_acta)
            WHERE imagen_acta IS NOT NULL AND imagen_acta != ''
        ");

        Schema::table('resultados_mesas', function (Blueprint $table) {
            $table->longText('imagen_acta')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('resultados_mesas', function (Blueprint $table) {
            $table->string('imagen_acta')->nullable()->change();
        });
    }
};
