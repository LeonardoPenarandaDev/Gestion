<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n=== TESTIGOS EN LA BASE DE DATOS ===\n\n";

$testigos = App\Models\Testigo::with('puesto')->get();

if ($testigos->isEmpty()) {
    echo "No hay testigos registrados.\n\n";
} else {
    foreach($testigos as $t) {
        echo "ID: {$t->id}\n";
        echo "Documento: {$t->documento}\n";
        echo "Nombre: {$t->nombre}\n";
        echo "Puesto: {$t->puesto->nombre}\n";
        echo "User ID: " . ($t->user_id ?? 'Sin vincular') . "\n";
        echo str_repeat('-', 50) . "\n";
    }

    echo "\nTotal de testigos: " . $testigos->count() . "\n\n";
}
