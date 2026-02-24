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
        Schema::table('puesto', function (Blueprint $table) {
            $table->string('municipio_codigo', 5)->nullable()->after('id');
            $table->string('municipio_nombre', 100)->nullable()->after('municipio_codigo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('puesto', function (Blueprint $table) {
            $table->dropColumn(['municipio_codigo', 'municipio_nombre']);
        });
    }
};
