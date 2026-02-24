<?php

namespace App\Http\Controllers;

use App\Models\ResultadoMesa;

class ResultadoMesaController extends Controller
{
    public function desbloquear(ResultadoMesa $resultado)
    {
        $resultado->update(['bloqueada' => false]);

        return back()->with('success', 'Mesa #' . $resultado->mesa->numero_mesa . ' desbloqueada correctamente.');
    }
}