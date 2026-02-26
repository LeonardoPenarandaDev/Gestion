<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Testigo;
use App\Models\User;

echo "\n=== ULTIMOS TESTIGOS IMPORTADOS ===\n\n";

$testigos = Testigo::latest()->take(10)->get();

if ($testigos->isEmpty()) {
    echo "No hay testigos en la base de datos.\n";
    exit(0);
}

foreach($testigos as $t) {
    echo "Testigo: {$t->nombre} (Doc: {$t->documento})\n";
    echo "  user_id: " . ($t->user_id ?? 'NULL') . "\n";

    if($t->user_id) {
        $user = User::find($t->user_id);
        if($user) {
            echo "  -> Email: {$user->email}\n";
            echo "  -> Role: {$user->role}\n";
            echo "  -> Password esperado: testigo{$t->documento}\n";
        } else {
            echo "  -> ERROR: Usuario con ID {$t->user_id} no existe!\n";
        }
    } else {
        echo "  -> SIN USUARIO VINCULADO\n";
    }
    echo "\n";
}

echo "=== TOTAL USUARIOS CON ROL TESTIGO ===\n";
$totalTestigoUsers = User::where('role', 'testigo')->count();
echo "Total: {$totalTestigoUsers}\n\n";
