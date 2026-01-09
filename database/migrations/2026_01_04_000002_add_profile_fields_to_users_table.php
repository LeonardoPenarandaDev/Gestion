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
        Schema::table('users', function (Blueprint $table) {
            $table->string('sexo')->nullable()->after('email');
            $table->integer('edad')->nullable()->after('sexo');
            $table->date('fecha_nacimiento')->nullable()->after('edad');
            $table->string('telefono')->nullable()->after('fecha_nacimiento');
            $table->text('direccion')->nullable()->after('telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sexo', 'edad', 'fecha_nacimiento', 'telefono', 'direccion']);
        });
    }
};
