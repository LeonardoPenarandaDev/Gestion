<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\ResultadoMesa;
use App\Jobs\ProcesarReporteMesa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestigoPortalController extends Controller
{
    /**
     * Mostrar dashboard del testigo con sus mesas asignadas
     */
    public function index()
    {
        $user = auth()->user();
        $testigo = $user->testigo;

        $mesas = Mesa::with(['puesto', 'resultado'])
            ->where('testigo_id', $testigo->id)
            ->orderBy('numero_mesa')
            ->get();

        $mesasReportadas = $mesas->filter(fn($mesa) => $mesa->resultado)->count();
        $mesasPendientes = $mesas->count() - $mesasReportadas;

        return view('testigo-portal.index', compact('testigo', 'mesas', 'mesasReportadas', 'mesasPendientes'));
    }

    /**
     * Mostrar formulario para reportar resultado de una mesa
     */
    public function reportar($mesaId)
    {
        $user = auth()->user();
        $testigo = $user->testigo;

        $mesa = Mesa::with(['puesto', 'resultado'])
            ->where('id', $mesaId)
            ->where('testigo_id', $testigo->id)
            ->firstOrFail();

        $bloqueada = $mesa->resultado && $mesa->resultado->bloqueada;

        return view('testigo-portal.reportar', compact('mesa', 'testigo', 'bloqueada'));
    }

    /**
     * Guardar o actualizar el reporte de una mesa
     */
    public function guardarReporte(Request $request, $mesaId)
    {
        $user = auth()->user();
        $testigo = $user->testigo;

        $mesa = Mesa::with('resultado')->where('id', $mesaId)
            ->where('testigo_id', $testigo->id)
            ->firstOrFail();

        // Bloquear si ya fue enviada
        if ($mesa->resultado && $mesa->resultado->bloqueada) {
            return redirect()
                ->route('testigo.portal')
                ->with('error', 'Esta mesa ya fue enviada y está bloqueada. Contacta al administrador para modificarla.');
        }

        $request->validate([
            'imagen_acta' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'observacion' => 'required|string|max:1000',
            'total_votos' => 'nullable|integer|min:0',
            'votos_competencia' => 'nullable|integer|min:0',
        ], [
            'imagen_acta.image' => 'El archivo debe ser una imagen.',
            'imagen_acta.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg.',
            'imagen_acta.max' => 'La imagen no debe ser mayor a 5MB.',
            'observacion.required' => 'La observación es obligatoria.',
            'observacion.max' => 'La observación no debe exceder 1000 caracteres.',
            'total_votos.integer' => 'El total de votos debe ser un número entero.',
            'total_votos.min' => 'El total de votos no puede ser negativo.',
            'votos_competencia.integer' => 'Los votos de la competencia deben ser un número entero.',
            'votos_competencia.min' => 'Los votos de la competencia no pueden ser negativos.',
        ]);

        try {
            // 1. Guardar datos y bloquear la mesa INMEDIATAMENTE (síncrono)
            $resultado = ResultadoMesa::firstOrNew(['mesa_id' => $mesa->id]);
            $resultado->testigo_id        = $testigo->id;
            $resultado->observacion       = $request->observacion;
            $resultado->total_votos       = $request->total_votos;
            $resultado->votos_competencia = $request->votos_competencia;
            $resultado->estado            = 'enviado';
            $resultado->bloqueada         = true;
            $resultado->save();

            // 2. Si hay imagen, guardarla en temp y despachar job para moverla
            if ($request->hasFile('imagen_acta')) {
                $extension     = $request->file('imagen_acta')->getClientOriginalExtension();
                $nombreTemp    = 'actas_temp/' . Str::uuid() . '.' . $extension;
                Storage::disk('local')->put(
                    $nombreTemp,
                    file_get_contents($request->file('imagen_acta')->getRealPath())
                );

                ProcesarReporteMesa::dispatch(
                    $mesa->id,
                    $testigo->id,
                    $request->observacion,
                    $request->total_votos,
                    $request->votos_competencia,
                    $nombreTemp,
                    $resultado->imagen_acta,
                );
            }

            return redirect()
                ->route('testigo.portal')
                ->with('success', 'Reporte enviado correctamente. Mesa #' . $mesa->numero_mesa);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al enviar el reporte: ' . $e->getMessage());
        }
    }
}
