<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "\n=== ESTRUCTURA DE LA COLUMNA ROLE ===\n\n";

// Ver estructura de la tabla users
$columns = DB::select('SHOW COLUMNS FROM users WHERE Field = "role"');

if (!empty($columns)) {
    $roleColumn = $columns[0];
    echo "Campo: " . $roleColumn->Field . "\n";
    echo "Tipo: " . $roleColumn->Type . "\n";
    echo "Permite NULL: " . $roleColumn->Null . "\n";
    echo "Valor por defecto: " . ($roleColumn->Default ?? 'NULL') . "\n";
} else {
    echo "La columna 'role' no existe.\n";
}

echo "\n=== USUARIOS EXISTENTES ===\n\n";
$users = DB::select('SELECT id, name, email, role FROM users');

if (empty($users)) {
    echo "No hay usuarios en la base de datos.\n";
} else {
    foreach($users as $user) {
        echo "ID: {$user->id} | Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Role: " . ($user->role ?? 'NULL') . "\n";
        echo str_repeat('-', 50) . "\n";
    }
}

echo "\n";
