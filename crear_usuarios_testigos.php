<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Testigo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "\n=== CREAR USUARIOS PARA TESTIGOS ===\n\n";

// Obtener testigos sin usuario vinculado
$testigos = Testigo::whereNull('user_id')->with('puesto')->get();

if ($testigos->isEmpty()) {
    echo "✓ Todos los testigos ya tienen usuarios vinculados.\n\n";
    exit(0);
}

echo "Se crearán usuarios para " . $testigos->count() . " testigos:\n\n";

$usuariosCreados = 0;

foreach($testigos as $testigo) {
    echo "Procesando: {$testigo->nombre} (Doc: {$testigo->documento})\n";

    // Generar email basado en el documento
    $email = strtolower(str_replace(' ', '.', $testigo->nombre)) . '@testigo.com';
    $email = preg_replace('/[^a-z0-9@.]/', '', $email);

    // Si el email ya existe, agregar el documento
    if (User::where('email', $email)->exists()) {
        $email = 'testigo.' . $testigo->documento . '@testigo.com';
    }

    // Contraseña: testigo + documento
    $password = 'testigo' . $testigo->documento;

    try {
        // Crear usuario
        $user = User::create([
            'name' => $testigo->nombre,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'testigo',
            'email_verified_at' => now(), // Ya verificado
        ]);

        // Vincular testigo con usuario
        $testigo->user_id = $user->id;
        $testigo->save();

        echo "  ✓ Usuario creado\n";
        echo "    Email: {$email}\n";
        echo "    Contraseña: {$password}\n";
        echo "    User ID: {$user->id}\n\n";

        $usuariosCreados++;

    } catch (\Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n\n";
    }
}

echo str_repeat('=', 60) . "\n";
echo "RESUMEN:\n";
echo "Usuarios creados: {$usuariosCreados}\n\n";

// Mostrar credenciales de todos los testigos
echo "=== CREDENCIALES DE ACCESO ===\n\n";
$todosTestigos = Testigo::whereNotNull('user_id')->with('user')->get();

foreach($todosTestigos as $t) {
    // Reconstruir la contraseña (testigo + documento)
    $pass = 'testigo' . $t->documento;
    echo "Testigo: {$t->nombre}\n";
    echo "Email: {$t->user->email}\n";
    echo "Contraseña: {$pass}\n";
    echo "URL: http://localhost/testigo/portal\n";
    echo str_repeat('-', 50) . "\n";
}

echo "\n✓ Proceso completado!\n\n";
