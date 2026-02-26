<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Testigo;
use App\Models\ResultadoMesa;
use App\Models\Candidato;
use App\Models\VotoCandidato;
use App\Jobs\ProcesarReporteMesa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestigoPortalController extends Controller
{
    /**
     * Mostrar dashboard del testigo o coordinador
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isCoordinador()) {
            // Coordinador: ve todas las mesas de todos los testigos
            $testigos = Testigo::with(['mesas.puesto', 'mesas.resultado', 'puesto'])
                ->orderBy('nombre')
                ->get();

            $totalMesas      = $testigos->sum(fn($t) => $t->mesas->count());
            $mesasReportadas = $testigos->sum(fn($t) => $t->mesas->filter(fn($m) => $m->resultado)->count());
            $mesasPendientes = $totalMesas - $mesasReportadas;

            return view('testigo-portal.coordinador', compact(
                'testigos', 'totalMesas', 'mesasReportadas', 'mesasPendientes'
            ));
        }

        // Testigo normal: solo sus mesas
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

        if ($user->isCoordinador()) {
            $mesa    = Mesa::with(['puesto', 'resultado.votosCandidatos.candidato', 'testigo'])
                ->findOrFail($mesaId);
            $testigo = $mesa->testigo;
        } else {
            $testigo = $user->testigo;
            $mesa    = Mesa::with(['puesto', 'resultado.votosCandidatos.candidato'])
                ->where('id', $mesaId)
                ->where('testigo_id', $testigo->id)
                ->firstOrFail();
        }

        $bloqueada = $mesa->resultado && $mesa->resultado->bloqueada;

        $candidatoPropio       = Candidato::where('tipo', 'propio')->activos()->first();
        $candidatosCompetencia = Candidato::where('tipo', 'competencia')->activos()->get();

        $votosPrevios = [];
        if ($mesa->resultado) {
            foreach ($mesa->resultado->votosCandidatos as $vc) {
                $votosPrevios[$vc->candidato_id] = $vc->votos;
            }
        }

        return view('testigo-portal.reportar', compact(
            'mesa', 'testigo', 'bloqueada',
            'candidatoPropio', 'candidatosCompetencia', 'votosPrevios'
        ));
    }

    /**
     * Guardar o actualizar el reporte de una mesa
     */
    public function guardarReporte(Request $request, $mesaId)
    {
        $user = auth()->user();

        if ($user->isCoordinador()) {
            $mesa    = Mesa::with('resultado')->findOrFail($mesaId);
            $testigo = $mesa->testigo;
        } else {
            $testigo = $user->testigo;
            $mesa    = Mesa::with('resultado')
                ->where('id', $mesaId)
                ->where('testigo_id', $testigo->id)
                ->firstOrFail();
        }

        if ($mesa->resultado && $mesa->resultado->bloqueada) {
            return redirect()
                ->route('testigo.portal')
                ->with('error', 'Esta mesa ya fue enviada y está bloqueada. Contacta al administrador para modificarla.');
        }

        $request->validate([
            'imagen_acta'       => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'observacion'       => 'required|string|max:1000',
            'votos_candidato.*' => 'nullable|integer|min:0',
        ], [
            'imagen_acta.image'    => 'El archivo debe ser una imagen.',
            'imagen_acta.mimes'    => 'La imagen debe ser de tipo: jpeg, png, jpg.',
            'imagen_acta.max'      => 'La imagen no debe ser mayor a 5MB.',
            'observacion.required' => 'La observación es obligatoria.',
            'observacion.max'      => 'La observación no debe exceder 1000 caracteres.',
        ]);

        try {
            $votosData = $request->input('votos_candidato', []);

            $candidatoPropio      = Candidato::where('tipo', 'propio')->first();
            $totalVotosPropio     = isset($votosData[$candidatoPropio->id])
                ? (int) $votosData[$candidatoPropio->id]
                : 0;

            $totalVotosCompetencia = 0;
            foreach ($votosData as $candidatoId => $votos) {
                if ((int) $candidatoId !== $candidatoPropio->id) {
                    $totalVotosCompetencia += (int) $votos;
                }
            }

            $resultado = ResultadoMesa::firstOrNew(['mesa_id' => $mesa->id]);
            $resultado->testigo_id        = $testigo->id;
            $resultado->observacion       = $request->observacion;
            $resultado->total_votos       = $totalVotosPropio;
            $resultado->votos_competencia = $totalVotosCompetencia;
            $resultado->estado            = 'enviado';
            $resultado->bloqueada         = true;
            $resultado->save();

            foreach ($votosData as $candidatoId => $votos) {
                VotoCandidato::updateOrCreate(
                    ['resultado_mesa_id' => $resultado->id, 'candidato_id' => (int) $candidatoId],
                    ['votos' => (int) $votos]
                );
            }

            if ($request->hasFile('imagen_acta')) {
                $extension  = $request->file('imagen_acta')->getClientOriginalExtension();
                $nombreTemp = 'actas_temp/' . Str::uuid() . '.' . $extension;
                Storage::disk('local')->put(
                    $nombreTemp,
                    file_get_contents($request->file('imagen_acta')->getRealPath())
                );

                ProcesarReporteMesa::dispatch(
                    $mesa->id,
                    $testigo->id,
                    $request->observacion,
                    $totalVotosPropio,
                    $totalVotosCompetencia,
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
