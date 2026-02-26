<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "\n╔══════════════════════════════════════════════════════════════════════╗\n";
echo "║               PRUEBA DE INICIO DE SESIÓN - TESTIGOS                 ║\n";
echo "╚══════════════════════════════════════════════════════════════════════╝\n\n";

// Listar todos los testigos con sus credenciales
$usuarios = User::where('role', 'testigo')->with('testigo')->get();

if ($usuarios->isEmpty()) {
    echo "⚠ No hay usuarios con rol testigo.\n\n";
    exit(1);
}

echo "USUARIOS DISPONIBLES PARA PRUEBA:\n\n";

foreach($usuarios as $i => $user) {
    $num = $i + 1;
    echo "[$num] {$user->name}\n";
    echo "    Email: {$user->email}\n";

    if ($user->testigo) {
        // La contraseña sigue el patrón: testigo + documento
        $password = 'testigo' . $user->testigo->documento;
        echo "    Contraseña: {$password}\n";
        echo "    Mesas asignadas: " . $user->testigo->mesas->count() . "\n";
    } else {
        echo "    ⚠ Sin testigo vinculado\n";
    }
    echo "\n";
}

echo "─────────────────────────────────────────────────────────────────────────\n\n";

// Prueba automática de login
echo "PRUEBA DE AUTENTICACIÓN:\n\n";

$testUser = $usuarios->first();
if ($testUser->testigo) {
    $email = $testUser->email;
    $password = 'testigo' . $testUser->testigo->documento;

    echo "Probando con:\n";
    echo "  Email: {$email}\n";
    echo "  Contraseña: {$password}\n\n";

    // Verificar que la contraseña coincide
    if (Hash::check($password, $testUser->password)) {
        echo "✓ Contraseña correcta\n";
        echo "✓ Usuario: {$testUser->name}\n";
        echo "✓ Role: {$testUser->role}\n";
        echo "✓ Testigo vinculado: {$testUser->testigo->nombre}\n";
        echo "✓ Mesas asignadas: " . $testUser->testigo->mesas->count() . "\n\n";

        echo "╔══════════════════════════════════════════════════════════════════════╗\n";
        echo "║                     ✓ PRUEBA EXITOSA                                 ║\n";
        echo "╚══════════════════════════════════════════════════════════════════════╝\n\n";

        echo "Puede iniciar sesión en:\n";
        echo "URL: http://localhost/testigo/portal\n";
        echo "Email: {$email}\n";
        echo "Contraseña: {$password}\n\n";

    } else {
        echo "✗ Error: La contraseña no coincide\n\n";
    }
} else {
    echo "✗ El usuario no tiene testigo vinculado\n\n";
}
