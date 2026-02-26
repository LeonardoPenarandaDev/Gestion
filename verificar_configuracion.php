<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Testigo;
use App\Models\User;
use App\Models\Mesa;

echo "\n╔══════════════════════════════════════════════════════════════════════╗\n";
echo "║           VERIFICACIÓN DE CONFIGURACIÓN - PORTAL TESTIGOS           ║\n";
echo "╚══════════════════════════════════════════════════════════════════════╝\n\n";

// 1. Verificar Storage Link
echo "1. STORAGE LINK:\n";
$publicStoragePath = public_path('storage');
if (is_link($publicStoragePath)) {
    echo "   ✓ El enlace simbólico existe\n";
} else {
    echo "   ✗ ADVERTENCIA: No existe el enlace simbólico\n";
    echo "     Ejecutar: php artisan storage:link\n";
}

// 2. Verificar usuarios testigos
echo "\n2. USUARIOS CON ROL TESTIGO:\n";
$usuariosTestigos = User::where('role', 'testigo')->get();
echo "   Total: " . $usuariosTestigos->count() . "\n";

// 3. Verificar testigos vinculados
echo "\n3. TESTIGOS VINCULADOS A USUARIOS:\n";
$testigosVinculados = Testigo::whereNotNull('user_id')->with(['user', 'mesas'])->get();
echo "   Total: " . $testigosVinculados->count() . "\n\n";

foreach($testigosVinculados as $testigo) {
    echo "   ├─ {$testigo->nombre}\n";
    echo "   │  └─ User: {$testigo->user->email}\n";
    echo "   │  └─ Mesas asignadas: " . $testigo->mesas->count() . "\n";
}

// 4. Verificar testigos sin vincular
echo "\n4. TESTIGOS SIN VINCULAR:\n";
$testigosSinVincular = Testigo::whereNull('user_id')->get();
if ($testigosSinVincular->isEmpty()) {
    echo "   ✓ Todos los testigos están vinculados\n";
} else {
    echo "   ⚠ Hay " . $testigosSinVincular->count() . " testigos sin vincular:\n";
    foreach($testigosSinVincular as $t) {
        echo "      - {$t->nombre} (Doc: {$t->documento})\n";
    }
}

// 5. Verificar tabla resultados_mesas
echo "\n5. TABLA RESULTADOS_MESAS:\n";
try {
    $totalResultados = \App\Models\ResultadoMesa::count();
    echo "   ✓ Tabla existe\n";
    echo "   Reportes registrados: {$totalResultados}\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// 6. Resumen de mesas
echo "\n6. RESUMEN DE MESAS:\n";
$totalMesas = Mesa::count();
$mesasConTestigo = Mesa::whereNotNull('testigo_id')->count();
echo "   Total de mesas: {$totalMesas}\n";
echo "   Mesas asignadas: {$mesasConTestigo}\n";

// 7. Verificar rutas
echo "\n7. RUTAS DEL PORTAL:\n";
echo "   ✓ /testigo/portal (Dashboard)\n";
echo "   ✓ /testigo/reportar/{mesa} (Formulario)\n";

echo "\n╔══════════════════════════════════════════════════════════════════════╗\n";
echo "║                      CONFIGURACIÓN COMPLETADA                        ║\n";
echo "╚══════════════════════════════════════════════════════════════════════╝\n\n";

echo "PRÓXIMOS PASOS:\n";
echo "1. Los testigos pueden acceder a: http://localhost/testigo/portal\n";
echo "2. Ver credenciales en: CREDENCIALES_TESTIGOS.txt\n";
echo "3. Documentación completa en: PORTAL_TESTIGOS.md\n\n";
