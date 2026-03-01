<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coordinadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('fk_id_zona', 10);
            $table->unsignedBigInteger('fk_id_puesto');
            $table->foreign('fk_id_puesto')->references('id')->on('puesto')->onDelete('cascade');
            $table->string('documento', 20)->unique();
            $table->string('nombre', 60);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coordinadores');
    }
};
