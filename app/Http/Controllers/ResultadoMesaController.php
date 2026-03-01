<?php

namespace App\Http\Controllers;

use App\Models\ResultadoMesa;
use App\Models\Eleccion;
use App\Models\Puesto;
use App\Models\Candidato;

class ResultadoMesaController extends Controller
{
    public function actas()
    {
        $municipioFiltro = request('municipio');
        $puestoFiltro    = request('puesto');
        $eleccionFiltro  = request('eleccion');
        $fotosFiltro     = request('fotos'); // 'con', 'sin', or null

        $query = ResultadoMesa::with([
            'mesa.puesto',
            'testigo',
            'votosCandidatos.candidato',
            'eleccion',
        ]);

        if ($municipioFiltro) {
            $query->whereHas('mesa.puesto', fn($q) => $q->where('municipio_codigo', $municipioFiltro));
        }

        if ($puestoFiltro) {
            $query->whereHas('mesa', fn($q) => $q->where('puesto_id', $puestoFiltro));
        }

        if ($eleccionFiltro) {
            $query->where('eleccion_id', $eleccionFiltro);
        }

        if ($fotosFiltro === 'con') {
            $query->whereNotNull('imagen_acta')->where('imagen_acta', '!=', '[]')->where('imagen_acta', '!=', 'null');
        } elseif ($fotosFiltro === 'sin') {
            $query->where(fn($q) => $q->whereNull('imagen_acta')->orWhere('imagen_acta', '[]')->orWhere('imagen_acta', 'null'));
        }

        $resultados = $query->orderBy('eleccion_id')->orderBy('updated_at', 'desc')->get();

        // Candidatos propios indexados por eleccion_id
        $candidatosPropios = Candidato::where('tipo', 'propio')->where('activo', true)
            ->get()->keyBy('eleccion_id');

        $elecciones = Eleccion::orderBy('fecha')->get();

        $municipios = Puesto::select('municipio_codigo', 'municipio_nombre')
            ->distinct()
            ->orderBy('municipio_nombre')
            ->get();

        $puestos = $puestoFiltro || $municipioFiltro
            ? Puesto::when($municipioFiltro, fn($q) => $q->where('municipio_codigo', $municipioFiltro))
                ->orderBy('nombre')->get()
            : collect();

        return view('actas.index', compact(
            'resultados', 'candidatosPropios', 'elecciones',
            'municipios', 'puestos',
            'municipioFiltro', 'puestoFiltro', 'eleccionFiltro', 'fotosFiltro'
        ));
    }

    public function desbloquear(ResultadoMesa $resultado)
    {
        $resultado->update(['bloqueada' => false]);

        return back()->with('success', 'Mesa #' . $resultado->mesa->numero_mesa . ' desbloqueada correctamente.');
    }
}
