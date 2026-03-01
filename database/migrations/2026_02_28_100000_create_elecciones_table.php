<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elecciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->date('fecha')->nullable();
            $table->string('tipo_cargo', 60)->default('senado'); // senado, camara, presidencia, concejo, alcaldia, etc.
            $table->text('descripcion')->nullable();
            $table->string('color', 20)->default('#2563eb'); // color del encabezado en la UI
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });

        // Crear la elección por defecto para los candidatos de Senado ya existentes
        DB::table('elecciones')->insert([
            'nombre'     => 'Senado - Congreso 2026',
            'fecha'      => '2026-03-08',
            'tipo_cargo' => 'senado',
            'color'      => '#1d4ed8',
            'activa'     => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar todos los candidatos existentes a esa elección
        Schema::table('candidatos', function (Blueprint $table) {
            $table->foreignId('eleccion_id')->nullable()->constrained('elecciones')->nullOnDelete()->after('id');
        });

        $eleccionId = DB::table('elecciones')->first()->id;
        DB::table('candidatos')->whereNull('eleccion_id')->update(['eleccion_id' => $eleccionId]);
    }

    public function down(): void
    {
        Schema::table('candidatos', function (Blueprint $table) {
            $table->dropForeign(['eleccion_id']);
            $table->dropColumn('eleccion_id');
        });
        Schema::dropIfExists('elecciones');
    }
};
