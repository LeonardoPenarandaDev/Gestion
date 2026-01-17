<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testigo', function (Blueprint $table) {
            // Cambiar el campo mesas de integer a string para almacenar múltiples valores
            $table->string('mesas', 200)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('testigo', function (Blueprint $table) {
            $table->integer('mesas')->change();
        });
    }
};