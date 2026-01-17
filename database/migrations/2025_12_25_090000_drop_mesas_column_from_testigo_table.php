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
            if (Schema::hasColumn('testigo', 'mesas')) {
                $table->dropColumn('mesas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testigo', function (Blueprint $table) {
            if (!Schema::hasColumn('testigo', 'mesas')) {
                $table->integer('mesas')->nullable();
            }
        });
    }
};
