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
        Schema::table('testigo', function (Blueprint $table) {
            // Cambiar fk_id_zona a VARCHAR más largo (para soportar "1" hasta "99")
            $table->string('fk_id_zona', 10)->change();
            
            // Cambiar fk_id_puesto a BIGINT sin signo (para IDs grandes)
            $table->unsignedBigInteger('fk_id_puesto')->change();
            
            // Agregar columnas documento y nombre si no existen
            if (!Schema::hasColumn('testigo', 'documento')) {
                $table->string('documento', 20)->nullable()->unique()->after('fk_id_puesto');
            }
            
            if (!Schema::hasColumn('testigo', 'nombre')) {
                $table->string('nombre', 30)->nullable()->after('documento');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testigo', function (Blueprint $table) {
            $table->string('fk_id_zona', 2)->change();
            $table->string('fk_id_puesto', 2)->change();
            
            if (Schema::hasColumn('testigo', 'documento')) {
                $table->dropColumn('documento');
            }
            
            if (Schema::hasColumn('testigo', 'nombre')) {
                $table->dropColumn('nombre');
            }
        });
    }
};