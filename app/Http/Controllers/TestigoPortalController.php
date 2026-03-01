<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Testigo;
use App\Models\Coordinador;
use App\Models\ResultadoMesa;
use App\Models\Candidato;
use App\Models\Eleccion;
use App\Models\VotoCandidato;
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

        // Elecciones activas (necesarias para ambas vistas)
        $elecciones = Eleccion::where('activa', true)
            ->with(['candidatos' => fn($q) => $q->where('activo', true)->orderBy('orden')])
            ->orderBy('fecha')
            ->get();

        if ($user->isCoordinador()) {
            $coordinador = $user->coordinador;

            // Coordinador sin puesto asignado aún
            if (!$coordinador) {
                return view('testigo-portal.coordinador', [
                    'mesas'           => collect(),
                    'puesto'          => null,
                    'totalMesas'      => 0,
                    'mesasReportadas' => 0,
                    'mesasPendientes' => 0,
                    'elecciones'      => $elecciones,
                    'votosPuesto'     => collect(),
                ]);
            }

            $puesto = $coordinador->puesto;

            // Auto-crear mesas faltantes del puesto (sin testigo asignado)
            if ($puesto && $puesto->total_mesas > 0) {
                $existentes = Mesa::where('puesto_id', $coordinador->fk_id_puesto)
                    ->pluck('numero_mesa')
                    ->toArray();

                for ($n = 1; $n <= $puesto->total_mesas; $n++) {
                    if (!in_array($n, $existentes)) {
                        Mesa::create([
                            'testigo_id'  => null,
                            'puesto_id'   => $coordinador->fk_id_puesto,
                            'numero_mesa' => $n,
                        ]);
                    }
                }
            }

            // Cargar TODAS las mesas con sus resultados por elección
            $mesas = Mesa::with(['resultados.votosCandidatos.candidato', 'testigo'])
                ->where('puesto_id', $coordinador->fk_id_puesto)
                ->orderBy('numero_mesa')
                ->get();

            $totalMesas = $mesas->count();
            $eleccionIds = $elecciones->pluck('id');
            // Una mesa se considera "reportada" si tiene resultado en TODAS las elecciones activas
            $mesasReportadas = $mesas->filter(fn($m) =>
                $eleccionIds->every(fn($eid) => $m->resultados->where('eleccion_id', $eid)->isNotEmpty())
            )->count();
            $mesasPendientes = $totalMesas - $mesasReportadas;

            // Totales de votos por candidato en el puesto del coordinador
            $resultadoIds = $mesas->flatMap->resultados->pluck('id')->filter();
            $votosPuesto = VotoCandidato::with('candidato')
                ->whereIn('resultado_mesa_id', $resultadoIds)
                ->get()
                ->groupBy('candidato_id');

            return view('testigo-portal.coordinador', compact(
                'mesas', 'puesto', 'totalMesas', 'mesasReportadas', 'mesasPendientes',
                'elecciones', 'votosPuesto'
            ));
        }

        // Testigo normal: solo sus mesas
        $testigo = $user->testigo;

        $mesas = Mesa::with(['puesto', 'resultados'])
            ->where('testigo_id', $testigo->id)
            ->orderBy('numero_mesa')
            ->get();

        $eleccionIds = $elecciones->pluck('id');
        $mesasReportadas = $mesas->filter(fn($m) =>
            $eleccionIds->every(fn($eid) => $m->resultados->where('eleccion_id', $eid)->isNotEmpty())
        )->count();
        $mesasPendientes = $mesas->count() - $mesasReportadas;

        return view('testigo-portal.index', compact('testigo', 'mesas', 'mesasReportadas', 'mesasPendientes', 'elecciones'));
    }

    /**
     * Mostrar formulario para reportar resultado de una mesa (por elección)
     */
    public function reportar($mesaId, Eleccion $eleccion)
    {
        $user = auth()->user();

        if ($user->isCoordinador()) {
            $coordinador = $user->coordinador;
            $mesa = Mesa::with(['puesto', 'testigo'])
                ->where('puesto_id', $coordinador->fk_id_puesto)
                ->findOrFail($mesaId);
            $testigo = $mesa->testigo ?? null;
        } else {
            $testigo = $user->testigo;
            $mesa    = Mesa::with(['puesto'])
                ->where('id', $mesaId)
                ->where('testigo_id', $testigo->id)
                ->firstOrFail();
        }

        // Resultado de ESTA elección para esta mesa
        $resultado = ResultadoMesa::with('votosCandidatos')
            ->where('mesa_id', $mesa->id)
            ->where('eleccion_id', $eleccion->id)
            ->first();

        $bloqueada = $resultado && $resultado->bloqueada;

        // Solo candidatos de esta elección
        $eleccion->load(['candidatos' => fn($q) => $q->where('activo', true)->orderBy('orden')]);

        $votosPrevios = [];
        if ($resultado) {
            foreach ($resultado->votosCandidatos as $vc) {
                $votosPrevios[$vc->candidato_id] = $vc->votos;
            }
        }

        return view('testigo-portal.reportar', compact(
            'mesa', 'testigo', 'bloqueada', 'resultado',
            'eleccion', 'votosPrevios'
        ));
    }

    /**
     * Pre-subir una imagen al directorio temporal (responde JSON con el path)
     */
    public function uploadTemp(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $file       = $request->file('imagen');
        $extension  = $file->getClientOriginalExtension();
        $tempPath   = 'actas_temp/' . Str::uuid() . '.' . $extension;

        Storage::disk('local')->put(
            $tempPath,
            file_get_contents($file->getRealPath())
        );

        return response()->json(['temp_path' => $tempPath]);
    }

    /**
     * Guardar o actualizar el reporte de una mesa (por elección)
     */
    public function guardarReporte(Request $request, $mesaId, Eleccion $eleccion)
    {
        $user = auth()->user();

        if ($user->isCoordinador()) {
            $coordinador = $user->coordinador;
            $mesa = Mesa::where('puesto_id', $coordinador->fk_id_puesto)->findOrFail($mesaId);
            $testigo = $mesa->testigo ?? null;
        } else {
            $testigo = $user->testigo;
            $mesa    = Mesa::where('id', $mesaId)
                ->where('testigo_id', $testigo->id)
                ->firstOrFail();
        }

        // Verificar si YA está bloqueado para esta elección
        $resultadoExistente = ResultadoMesa::where('mesa_id', $mesa->id)
            ->where('eleccion_id', $eleccion->id)
            ->first();

        if ($resultadoExistente && $resultadoExistente->bloqueada) {
            return redirect()
                ->route('testigo.portal')
                ->with('error', 'El reporte de ' . $eleccion->nombre . ' para esta mesa ya fue enviado y está bloqueado.');
        }

        $request->validate([
            'observacion'       => 'required|string|max:1000',
            'votos_candidato.*' => 'nullable|integer|min:0',
            'imagenes_temp'     => 'nullable|array|max:10',
            'imagenes_temp.*'   => 'nullable|string',
        ], [
            'observacion.required' => 'La observación es obligatoria.',
            'observacion.max'      => 'La observación no debe exceder 1000 caracteres.',
        ]);

        try {
            $votosData = $request->input('votos_candidato', []);

            // Calcular totales para esta elección
            $candidatosIds = array_keys($votosData);
            $candidatosMap = Candidato::whereIn('id', $candidatosIds)->pluck('tipo', 'id');

            $totalVotosPropio      = 0;
            $totalVotosCompetencia = 0;
            foreach ($votosData as $candidatoId => $votos) {
                $tipo = $candidatosMap[(int) $candidatoId] ?? 'competencia';
                if ($tipo === 'propio') {
                    $totalVotosPropio += (int) $votos;
                } else {
                    $totalVotosCompetencia += (int) $votos;
                }
            }

            $resultado = ResultadoMesa::firstOrNew([
                'mesa_id'     => $mesa->id,
                'eleccion_id' => $eleccion->id,
            ]);

            // Imágenes existentes a conservar / eliminar
            $imagenesAKeep      = $request->input('imagenes_existentes', []);
            $imagenesAnteriores = $resultado->imagen_acta ?? [];
            $imagenesAEliminar  = array_values(array_diff($imagenesAnteriores, $imagenesAKeep));

            $resultado->testigo_id        = $testigo?->id;
            $resultado->observacion       = $request->observacion;
            $resultado->total_votos       = $totalVotosPropio;
            $resultado->votos_competencia = $totalVotosCompetencia;
            $resultado->estado            = 'enviado';
            $resultado->bloqueada         = true;
            $resultado->imagen_acta       = array_values($imagenesAKeep);
            $resultado->save();

            foreach ($votosData as $candidatoId => $votos) {
                VotoCandidato::updateOrCreate(
                    ['resultado_mesa_id' => $resultado->id, 'candidato_id' => (int) $candidatoId],
                    ['votos' => (int) $votos]
                );
            }

            // Eliminar imágenes quitadas
            foreach ($imagenesAEliminar as $imgVieja) {
                if ($imgVieja && Storage::disk('public')->exists($imgVieja)) {
                    Storage::disk('public')->delete($imgVieja);
                }
            }

            // Mover nuevas imágenes de temp a public
            $nuevasRutas = [];
            foreach ($request->input('imagenes_temp', []) as $tempPath) {
                if ($tempPath && Storage::disk('local')->exists($tempPath)) {
                    $destino = 'actas/' . basename($tempPath);
                    Storage::disk('public')->put($destino, Storage::disk('local')->get($tempPath));
                    Storage::disk('local')->delete($tempPath);
                    $nuevasRutas[] = $destino;
                }
            }

            if (!empty($nuevasRutas)) {
                $resultado->imagen_acta = array_merge($resultado->imagen_acta ?? [], $nuevasRutas);
                $resultado->save();
            }

            return redirect()
                ->route('testigo.portal')
                ->with('success', 'Reporte de ' . $eleccion->nombre . ' enviado. Mesa #' . $mesa->numero_mesa);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al enviar el reporte: ' . $e->getMessage());
        }
    }
}
