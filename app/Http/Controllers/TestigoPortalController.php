<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\ResultadoMesa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

        return view('testigo-portal.reportar', compact('mesa', 'testigo'));
    }

    /**
     * Guardar o actualizar el reporte de una mesa
     */
    public function guardarReporte(Request $request, $mesaId)
    {
        $user = auth()->user();
        $testigo = $user->testigo;

        $mesa = Mesa::where('id', $mesaId)
            ->where('testigo_id', $testigo->id)
            ->firstOrFail();

        $request->validate([
            'imagen_acta' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'observacion' => 'required|string|max:1000',
            'total_votos' => 'nullable|integer|min:0',
        ], [
            'imagen_acta.image' => 'El archivo debe ser una imagen.',
            'imagen_acta.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg.',
            'imagen_acta.max' => 'La imagen no debe ser mayor a 5MB.',
            'observacion.required' => 'La observación es obligatoria.',
            'observacion.max' => 'La observación no debe exceder 1000 caracteres.',
            'total_votos.integer' => 'El total de votos debe ser un número entero.',
            'total_votos.min' => 'El total de votos no puede ser negativo.',
        ]);

        DB::beginTransaction();
        try {
            $resultado = ResultadoMesa::firstOrNew(['mesa_id' => $mesa->id]);
            $resultado->testigo_id = $testigo->id;
            $resultado->observacion = $request->observacion;
            $resultado->total_votos = $request->total_votos;
            $resultado->estado = 'enviado';

            if ($request->hasFile('imagen_acta')) {
                if ($resultado->imagen_acta && Storage::disk('public')->exists($resultado->imagen_acta)) {
                    Storage::disk('public')->delete($resultado->imagen_acta);
                }

                $path = $request->file('imagen_acta')->store('actas', 'public');
                $resultado->imagen_acta = $path;
            }

            $resultado->save();

            DB::commit();

            return redirect()
                ->route('testigo.portal')
                ->with('success', 'Reporte enviado correctamente. Mesa #' . $mesa->numero_mesa);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al guardar el reporte: ' . $e->getMessage());
        }
    }
}
