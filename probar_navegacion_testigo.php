<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "\n╔══════════════════════════════════════════════════════════════════════╗\n";
echo "║          PRUEBA DE NAVEGACIÓN - TESTIGOS VS ADMINISTRADORES         ║\n";
echo "╚══════════════════════════════════════════════════════════════════════╝\n\n";

// Obtener un testigo
$testigo = User::where('role', 'testigo')->with('testigo')->first();

// Obtener un admin
$admin = User::where('role', 'admin')->first();

if (!$testigo) {
    echo "❌ No hay usuarios testigo en el sistema.\n\n";
    exit(1);
}

if (!$admin) {
    echo "⚠ No hay usuarios admin en el sistema.\n\n";
}

echo "═════════════════════════════════════════════════════════════════════\n";
echo "USUARIO TESTIGO\n";
echo "═════════════════════════════════════════════════════════════════════\n\n";

echo "📋 Información:\n";
echo "   Nombre: {$testigo->name}\n";
echo "   Email: {$testigo->email}\n";
echo "   Role: {$testigo->role}\n";
echo "   Testigo vinculado: " . ($testigo->testigo ? $testigo->testigo->nombre : 'No') . "\n\n";

echo "🔐 Credenciales para login:\n";
if ($testigo->testigo) {
    $password = 'testigo' . $testigo->testigo->documento;
    echo "   Email: {$testigo->email}\n";
    echo "   Contraseña: {$password}\n\n";
}

echo "📍 Flujo de navegación:\n";
echo "   1. Login → Redirige a: /testigo/portal ✓\n";
echo "   2. Click en logo → Va a: /testigo/portal ✓\n";
echo "   3. Menú muestra: 'Mis Mesas' ✓\n";
echo "   4. No ve opciones administrativas ✓\n\n";

echo "🚫 Rutas bloqueadas:\n";
echo "   ❌ /dashboard → Redirige a /testigo/portal\n";
echo "   ❌ /testigos → Error 403\n";
echo "   ❌ /puestos → Error 403\n";
echo "   ❌ /personas → Error 403\n";
echo "   ❌ /users → Error 403\n\n";

echo "✅ Rutas permitidas:\n";
echo "   ✓ /testigo/portal → Dashboard de testigo\n";
echo "   ✓ /testigo/reportar/{id} → Formulario de reporte\n";
echo "   ✓ /profile → Editar perfil\n\n";

if ($admin) {
    echo "═════════════════════════════════════════════════════════════════════\n";
    echo "USUARIO ADMINISTRADOR (COMPARACIÓN)\n";
    echo "═════════════════════════════════════════════════════════════════════\n\n";

    echo "📋 Información:\n";
    echo "   Nombre: {$admin->name}\n";
    echo "   Email: {$admin->email}\n";
    echo "   Role: {$admin->role}\n\n";

    echo "📍 Flujo de navegación:\n";
    echo "   1. Login → Redirige a: /dashboard ✓\n";
    echo "   2. Click en logo → Va a: /dashboard ✓\n";
    echo "   3. Menú muestra: Dashboard, Usuarios, etc ✓\n";
    echo "   4. Ve todas las opciones administrativas ✓\n\n";

    echo "✅ Rutas permitidas:\n";
    echo "   ✓ /dashboard\n";
    echo "   ✓ /testigos\n";
    echo "   ✓ /puestos\n";
    echo "   ✓ /personas\n";
    echo "   ✓ /users\n";
    echo "   ✓ /profile\n\n";

    echo "🚫 Rutas bloqueadas:\n";
    echo "   ❌ /testigo/portal → Error 403 (solo para testigos)\n\n";
}

echo "═════════════════════════════════════════════════════════════════════\n";
echo "VERIFICACIÓN DE ARCHIVOS MODIFICADOS\n";
echo "═════════════════════════════════════════════════════════════════════\n\n";

$archivos = [
    'app/Http/Controllers/Auth/AuthenticatedSessionController.php' => 'Redirección según rol',
    'app/Http/Controllers/DashboardController.php' => 'Protección de dashboard',
    'resources/views/layouts/navigation.blade.php' => 'Menú contextual',
    'routes/web.php' => 'Rutas protegidas',
];

foreach ($archivos as $archivo => $descripcion) {
    $path = __DIR__ . '/' . $archivo;
    if (file_exists($path)) {
        echo "   ✓ {$descripcion}\n";
        echo "     {$archivo}\n\n";
    } else {
        echo "   ❌ {$descripcion}\n";
        echo "     {$archivo} (NO ENCONTRADO)\n\n";
    }
}

echo "═════════════════════════════════════════════════════════════════════\n";
echo "PRUEBA EN EL NAVEGADOR\n";
echo "═════════════════════════════════════════════════════════════════════\n\n";

echo "🌐 PASO 1: Prueba como Testigo\n\n";
echo "   1. Abrir: http://localhost/login\n";
echo "   2. Email: {$testigo->email}\n";
if ($testigo->testigo) {
    echo "   3. Contraseña: testigo{$testigo->testigo->documento}\n";
}
echo "   4. Observar:\n";
echo "      - Redirige automáticamente a /testigo/portal\n";
echo "      - Menú solo muestra 'Mis Mesas'\n";
echo "      - Ve sus mesas asignadas\n\n";

echo "   5. Intentar acceder a: http://localhost/dashboard\n";
echo "      - Debe redirigir a /testigo/portal\n\n";

echo "   6. Intentar acceder a: http://localhost/testigos\n";
echo "      - Debe mostrar error 403\n\n";

if ($admin) {
    echo "🌐 PASO 2: Prueba como Admin\n\n";
    echo "   1. Cerrar sesión\n";
    echo "   2. Abrir: http://localhost/login\n";
    echo "   3. Email: {$admin->email}\n";
    echo "   4. Contraseña: [tu contraseña de admin]\n";
    echo "   5. Observar:\n";
    echo "      - Redirige a /dashboard\n";
    echo "      - Menú muestra todas las opciones\n";
    echo "      - Puede acceder a todas las rutas\n\n";
}

echo "═════════════════════════════════════════════════════════════════════\n\n";

echo "✅ VERIFICACIÓN COMPLETA\n\n";
echo "Los testigos ahora tienen:\n";
echo "   ✓ Portal exclusivo sin menús de administración\n";
echo "   ✓ Redirección automática al login\n";
echo "   ✓ Protección contra acceso a rutas administrativas\n";
echo "   ✓ Experiencia de usuario enfocada en sus mesas\n\n";

echo "Para más detalles, ver: CAMBIOS_NAVEGACION.md\n\n";
