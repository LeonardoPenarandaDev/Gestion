<?php

namespace App\Http\Controllers;

use App\Models\Eleccion;
use App\Models\Candidato;
use Illuminate\Http\Request;

class EleccionController extends Controller
{
    public function index()
    {
        $elecciones = Eleccion::with(['candidatos' => fn($q) => $q->orderBy('orden')])
            ->orderBy('activa', 'desc')
            ->orderBy('fecha')
            ->get();

        return view('elecciones.index', compact('elecciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string|max:120',
            'fecha'      => 'nullable|date',
            'tipo_cargo' => 'required|string|max:60',
            'descripcion'=> 'nullable|string|max:500',
            'color'      => 'nullable|string|max:20',
        ]);

        Eleccion::create([
            'nombre'      => $request->nombre,
            'fecha'       => $request->fecha,
            'tipo_cargo'  => strtolower(trim($request->tipo_cargo)),
            'descripcion' => $request->descripcion,
            'color'       => $request->color ?? '#2563eb',
            'activa'      => true,
        ]);

        return back()->with('success', 'Elección "' . $request->nombre . '" creada correctamente.');
    }

    public function update(Request $request, Eleccion $eleccion)
    {
        $request->validate([
            'nombre'      => 'required|string|max:120',
            'fecha'       => 'nullable|date',
            'tipo_cargo'  => 'required|string|max:60',
            'descripcion' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:20',
        ]);

        $eleccion->update([
            'nombre'      => $request->nombre,
            'fecha'       => $request->fecha,
            'tipo_cargo'  => strtolower(trim($request->tipo_cargo)),
            'descripcion' => $request->descripcion,
            'color'       => $request->color ?? $eleccion->color,
        ]);

        return back()->with('success', 'Elección actualizada.');
    }

    public function toggleActiva(Eleccion $eleccion)
    {
        $eleccion->update(['activa' => !$eleccion->activa]);
        $estado = $eleccion->activa ? 'activada' : 'desactivada';
        return back()->with('success', "Elección \"{$eleccion->nombre}\" {$estado}.");
    }

    public function destroy(Eleccion $eleccion)
    {
        if ($eleccion->candidatos()->exists()) {
            return back()->with('error', 'No se puede eliminar una elección que tiene candidatos. Elimina primero los candidatos.');
        }
        $eleccion->delete();
        return back()->with('success', 'Elección eliminada.');
    }

    // ── Gestión de candidatos ──────────────────────────────────────────────

    public function storeCandidato(Request $request, Eleccion $eleccion)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo'   => 'required|in:propio,competencia',
            'orden'  => 'nullable|integer|min:0',
        ]);

        $maxOrden = $eleccion->candidatos()->max('orden') ?? 0;

        Candidato::create([
            'eleccion_id' => $eleccion->id,
            'nombre'      => $request->nombre,
            'tipo'        => $request->tipo,
            'cargo'       => $eleccion->tipo_cargo,
            'orden'       => $request->orden ?? ($maxOrden + 1),
            'activo'      => true,
        ]);

        return back()->with('success', 'Candidato "' . $request->nombre . '" agregado.');
    }

    public function updateCandidato(Request $request, Eleccion $eleccion, Candidato $candidato)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo'   => 'required|in:propio,competencia',
            'orden'  => 'nullable|integer|min:0',
        ]);

        $candidato->update([
            'nombre' => $request->nombre,
            'tipo'   => $request->tipo,
            'orden'  => $request->orden ?? $candidato->orden,
        ]);

        return back()->with('success', 'Candidato actualizado.');
    }

    public function toggleCandidato(Eleccion $eleccion, Candidato $candidato)
    {
        $candidato->update(['activo' => !$candidato->activo]);
        $estado = $candidato->activo ? 'activado' : 'desactivado';
        return back()->with('success', "Candidato \"{$candidato->nombre}\" {$estado}.");
    }

    public function destroyCandidato(Eleccion $eleccion, Candidato $candidato)
    {
        if ($candidato->votosCandidatos()->exists()) {
            // Desactivar en vez de borrar si tiene votos registrados
            $candidato->update(['activo' => false]);
            return back()->with('success', 'Candidato desactivado (tiene votos registrados, no se puede eliminar).');
        }
        $candidato->delete();
        return back()->with('success', 'Candidato eliminado.');
    }
}
