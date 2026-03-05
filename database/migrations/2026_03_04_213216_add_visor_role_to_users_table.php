<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','editor','testigo','coordinador','visor') NOT NULL DEFAULT 'testigo'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','editor','testigo','coordinador') NOT NULL DEFAULT 'testigo'");
    }
};
