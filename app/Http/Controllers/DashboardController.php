<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Puesto;
use App\Models\Testigo;
use App\Models\InfoElectoral;
use App\Models\InfoTestigo;
use App\Models\Mesa;
use App\Models\ResultadoMesa;
use App\Models\Candidato;
use App\Models\Eleccion;
use App\Models\Coordinador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal
     */
    public function index()
    {
        // Redirigir testigos y coordinadores a su portal
        if (auth()->user()->isTestigo() || auth()->user()->isCoordinador()) {
            return redirect()->route('testigo.portal');
        }

        // Redirigir editores a la lista de testigos
        if (auth()->user()->isEditor()) {
            return redirect()->route('testigos.index');
        }

        // Estadísticas generales
        $totalPersonas = Persona::count();
        $totalPuestos = Puesto::count();

        // Total de mesas disponibles (suma del campo total_mesas de la tabla puestos)
        $totalMesas = Puesto::sum('total_mesas') ?? 0;

        // Mesas cubiertas: puestos con coordinador + mesas de testigos en puestos sin coordinador
        $mesasCubiertas = $this->_mesasCubiertas();

        $totalTestigos = Testigo::count();
        $totalCoordinadores = InfoElectoral::coordinadores()->count();
        $totalLideres = InfoElectoral::lideres()->count();
        
        // Mesas pendientes
        $totalMesasPendientes = max(0, $totalMesas - $mesasCubiertas);

        // Estadísticas de reportes de votos
        $totalReportes = ResultadoMesa::count();
        $totalVotosReportados = ResultadoMesa::sum('total_votos') ?? 0;
        $totalVotosCompetencia = ResultadoMesa::sum('votos_competencia') ?? 0;
        $mesasReportadas = ResultadoMesa::distinct('mesa_id')->count('mesa_id');
        $mesasSinReportar = $mesasCubiertas - $mesasReportadas;

        // Elecciones con resumen de votos por elección
        $elecciones = Eleccion::orderBy('activa', 'desc')
            ->orderBy('fecha')
            ->get()
            ->map(function ($eleccion) {
                $resumen = DB::table('candidatos')
                    ->leftJoin('votos_candidatos', 'candidatos.id', '=', 'votos_candidatos.candidato_id')
                    ->where('candidatos.eleccion_id', $eleccion->id)
                    ->select(
                        'candidatos.tipo',
                        DB::raw('COALESCE(SUM(votos_candidatos.votos), 0) as total_votos')
                    )
                    ->groupBy('candidatos.tipo')
                    ->get()
                    ->keyBy('tipo');

                $eleccion->votos_propio      = (int) ($resumen['propio']->total_votos      ?? 0);
                $eleccion->votos_competencia = (int) ($resumen['competencia']->total_votos ?? 0);
                $eleccion->candidatos_count  = $eleccion->candidatos()->where('activo', true)->count();
                $eleccion->mesas_reportadas_elec = ResultadoMesa::where('eleccion_id', $eleccion->id)
                    ->distinct('mesa_id')->count('mesa_id');
                return $eleccion;
            });

        // Últimos reportes agrupados por elección (todas, incluso sin reportes aún)
        $ultimosReportesPorEleccion = Eleccion::orderBy('fecha')
            ->get()
            ->map(function ($eleccion) {
                $reportes = ResultadoMesa::with(['mesa.puesto', 'testigo'])
                    ->where('eleccion_id', $eleccion->id)
                    ->latest()
                    ->take(10)
                    ->get();
                $eleccion->ultimosReportes = $reportes;
                return $eleccion;
            });

        // Compatibilidad: $ultimosReportes = todos juntos para el contador
        $ultimosReportes = ResultadoMesa::with(['mesa.puesto', 'testigo', 'eleccion'])
            ->latest()
            ->take(10)
            ->get();

        // Votos por puesto
        $votosPorPuesto = DB::table('resultados_mesas')
            ->join('mesas', 'resultados_mesas.mesa_id', '=', 'mesas.id')
            ->join('puesto', 'mesas.puesto_id', '=', 'puesto.id')
            ->select(
                'puesto.id',
                'puesto.nombre',
                'puesto.zona',
                'puesto.municipio_codigo',
                'puesto.municipio_nombre',
                DB::raw('COUNT(DISTINCT resultados_mesas.mesa_id) as mesas_reportadas'),
                DB::raw('SUM(resultados_mesas.total_votos) as total_votos'),
                DB::raw('SUM(resultados_mesas.votos_competencia) as votos_competencia')
            )
            ->groupBy('puesto.id', 'puesto.nombre', 'puesto.zona', 'puesto.municipio_codigo', 'puesto.municipio_nombre')
            ->orderBy('puesto.municipio_nombre')
            ->orderByDesc('total_votos')
            ->get();

        // Mesas reportadas y votos por puesto desglosados por elección
        $votosPorMesaElec = DB::table('mesas')
            ->join('resultados_mesas', 'mesas.id', '=', 'resultados_mesas.mesa_id')
            ->select(
                'mesas.puesto_id',
                'resultados_mesas.eleccion_id',
                DB::raw('COUNT(DISTINCT resultados_mesas.mesa_id) as mesas_reportadas'),
                DB::raw('COALESCE(SUM(resultados_mesas.total_votos), 0) as total_votos'),
                DB::raw('COALESCE(SUM(resultados_mesas.votos_competencia), 0) as votos_competencia')
            )
            ->groupBy('mesas.puesto_id', 'resultados_mesas.eleccion_id')
            ->get()
            ->groupBy('puesto_id')
            ->map(fn($rows) => $rows->keyBy('eleccion_id'));

        // Votos por puesto (TODAS las mesas: base = puesto.total_mesas, no tabla mesas)
        $votosPorMesa = DB::table('puesto')
            ->leftJoin('coordinadores', 'puesto.id', '=', 'coordinadores.fk_id_puesto')
            ->leftJoin('mesas', 'puesto.id', '=', 'mesas.puesto_id')
            ->leftJoin('resultados_mesas', 'mesas.id', '=', 'resultados_mesas.mesa_id')
            ->select(
                'puesto.id',
                'puesto.nombre as puesto_nombre',
                'puesto.zona',
                'puesto.municipio_nombre',
                'puesto.total_mesas',
                DB::raw('COUNT(DISTINCT coordinadores.id) as num_coordinadores'),
                DB::raw('COUNT(DISTINCT resultados_mesas.mesa_id) as mesas_reportadas'),
                DB::raw('COALESCE(SUM(resultados_mesas.total_votos), 0) as total_votos'),
                DB::raw('COALESCE(SUM(resultados_mesas.votos_competencia), 0) as votos_competencia')
            )
            ->groupBy('puesto.id', 'puesto.nombre', 'puesto.zona', 'puesto.municipio_nombre', 'puesto.total_mesas')
            ->orderBy('puesto.municipio_nombre')
            ->orderBy('puesto.nombre')
            ->get()
            ->map(function ($p) use ($votosPorMesaElec) {
                $p->tiene_reporte    = $p->mesas_reportadas > 0 ? 1 : 0;
                $p->pct_reportado    = $p->total_mesas > 0
                    ? round($p->mesas_reportadas / $p->total_mesas * 100) : 0;
                $p->tiene_cobertura  = $p->num_coordinadores > 0 || $p->mesas_reportadas > 0;
                $p->por_eleccion     = $votosPorMesaElec[$p->id] ?? collect();
                return $p;
            });

        // Personas por estado
        $personasPorEstado = Persona::selectRaw('estado, COUNT(*) as total')
                                   ->groupBy('estado')
                                   ->get();

        // Puestos por zona
        $puestosPorZona = Puesto::selectRaw('zona, COUNT(*) as total')
                                ->groupBy('zona')
                                ->orderBy('zona')
                                ->get();

        // Testigos por zona
        $testigosPorZona = Testigo::selectRaw('fk_id_zona as zona, COUNT(*) as total')
                                  ->groupBy('fk_id_zona')
                                  ->orderBy('fk_id_zona')
                                  ->get();

        // Actividad reciente (últimas personas registradas)
        $personasRecientes = Persona::latest()
                                   ->take(5)
                                   ->get();

        // Puestos con más testigos
        $puestosConMasTestigos = Puesto::withCount('testigos')
                                      ->orderBy('testigos_count', 'desc')
                                      ->take(5)
                                      ->get();

        return view('dashboard', compact(
            'totalPersonas',
            'totalPuestos',
            'totalMesas',
            'mesasCubiertas',
            'totalTestigos',
            'totalCoordinadores',
            'totalLideres',
            'totalMesasPendientes',
            'totalReportes',
            'totalVotosReportados',
            'totalVotosCompetencia',
            'mesasReportadas',
            'mesasSinReportar',
            'ultimosReportes',
            'ultimosReportesPorEleccion',
            'personasPorEstado',
            'puestosPorZona',
            'testigosPorZona',
            'personasRecientes',
            'puestosConMasTestigos',
            'votosPorPuesto',
            'votosPorMesa',
            'elecciones'
        ));
    }

    /**
     * Página de resultados de votación organizada — separada por elección
     */
    public function resultados()
    {
        $municipioFiltro = request('municipio');

        // Mapa candidato_id → tipo (propio/competencia)
        $candidatoTipoMap = Candidato::where('activo', true)->pluck('tipo', 'id');

        // Elecciones con ranking de candidatos por elección
        $elecciones = Eleccion::orderBy('fecha')->get()->map(function ($eleccion) {
            $ranking = DB::table('candidatos')
                ->leftJoin('votos_candidatos', 'candidatos.id', '=', 'votos_candidatos.candidato_id')
                ->where('candidatos.eleccion_id', $eleccion->id)
                ->where('candidatos.activo', true)
                ->select(
                    'candidatos.id',
                    'candidatos.nombre',
                    'candidatos.tipo',
                    'candidatos.orden',
                    DB::raw('COALESCE(SUM(votos_candidatos.votos), 0) as total_votos'),
                    DB::raw('COUNT(DISTINCT votos_candidatos.resultado_mesa_id) as num_mesas')
                )
                ->groupBy('candidatos.id', 'candidatos.nombre', 'candidatos.tipo', 'candidatos.orden')
                ->orderByDesc('total_votos')
                ->orderBy('candidatos.orden')
                ->get();

            $eleccion->ranking           = $ranking;
            $eleccion->votos_propio      = (int) $ranking->where('tipo', 'propio')->sum('total_votos');
            $eleccion->votos_competencia = (int) $ranking->where('tipo', 'competencia')->sum('total_votos');
            $eleccion->total_votos       = $eleccion->votos_propio + $eleccion->votos_competencia;
            return $eleccion;
        });

        // Totales globales
        $totalVotosPropio      = $elecciones->sum('votos_propio');
        $totalVotosCompetencia = $elecciones->sum('votos_competencia');
        $totalVotos            = $totalVotosPropio + $totalVotosCompetencia;

        $mesasReportadas = ResultadoMesa::distinct('mesa_id')->count('mesa_id');
        $totalMesas      = Puesto::sum('total_mesas') ?? 0;

        // Mesas con todos los resultados por elección
        $mesas = Mesa::with([
                'puesto',
                'resultados.votosCandidatos',
                'testigo',
            ])
            ->when($municipioFiltro, fn($q) =>
                $q->whereHas('puesto', fn($q2) => $q2->where('municipio_codigo', $municipioFiltro))
            )
            ->get()
            ->sortBy([
                fn($a, $b) => strcmp($a->puesto->municipio_nombre ?? '', $b->puesto->municipio_nombre ?? ''),
                fn($a, $b) => strcmp($a->puesto->nombre ?? '', $b->puesto->nombre ?? ''),
                fn($a, $b) => $a->numero_mesa <=> $b->numero_mesa,
            ]);

        // Agrupar: municipio → puesto → mesas[] con votos por elección
        $porMunicipio = [];
        foreach ($mesas as $mesa) {
            $munCodigo = $mesa->puesto->municipio_codigo ?? 'SIN';
            $munNombre = $mesa->puesto->municipio_nombre ?? 'Sin municipio';
            $puestoId  = $mesa->puesto_id;
            $puestoNom = $mesa->puesto->nombre ?? '—';

            $resultadosPorEleccion = $mesa->resultados->keyBy('eleccion_id');

            if (!isset($porMunicipio[$munCodigo])) {
                $porMunicipio[$munCodigo] = [
                    'nombre'          => $munNombre,
                    'puestos'         => [],
                    'votos_por_elec'  => [],
                    'mesas_reportadas'=> 0,
                    'total_mesas'     => 0,
                ];
            }
            if (!isset($porMunicipio[$munCodigo]['puestos'][$puestoId])) {
                $porMunicipio[$munCodigo]['puestos'][$puestoId] = [
                    'nombre'          => $puestoNom,
                    'mesas'           => [],
                    'votos_por_elec'  => [],
                    'mesas_reportadas'=> 0,
                ];
            }

            // Calcular votos por elección para esta mesa
            $mesaVotosElec     = [];
            $mesaAlgunaReport  = false;

            foreach ($elecciones as $eleccion) {
                $res   = $resultadosPorEleccion[$eleccion->id] ?? null;
                $vProp = 0;
                $vComp = 0;

                if ($res) {
                    $mesaAlgunaReport = true;
                    foreach ($res->votosCandidatos as $vc) {
                        $tipo = $candidatoTipoMap[$vc->candidato_id] ?? 'competencia';
                        if ($tipo === 'propio') $vProp += $vc->votos;
                        else                   $vComp += $vc->votos;
                    }
                }

                $mesaVotosElec[$eleccion->id] = [
                    'reportada'   => (bool) $res,
                    'bloqueada'   => $res?->bloqueada ?? false,
                    'propio'      => $vProp,
                    'competencia' => $vComp,
                ];

                // Acumular en puesto
                if (!isset($porMunicipio[$munCodigo]['puestos'][$puestoId]['votos_por_elec'][$eleccion->id])) {
                    $porMunicipio[$munCodigo]['puestos'][$puestoId]['votos_por_elec'][$eleccion->id] = ['propio' => 0, 'comp' => 0];
                }
                $porMunicipio[$munCodigo]['puestos'][$puestoId]['votos_por_elec'][$eleccion->id]['propio'] += $vProp;
                $porMunicipio[$munCodigo]['puestos'][$puestoId]['votos_por_elec'][$eleccion->id]['comp']   += $vComp;

                // Acumular en municipio
                if (!isset($porMunicipio[$munCodigo]['votos_por_elec'][$eleccion->id])) {
                    $porMunicipio[$munCodigo]['votos_por_elec'][$eleccion->id] = ['propio' => 0, 'comp' => 0];
                }
                $porMunicipio[$munCodigo]['votos_por_elec'][$eleccion->id]['propio'] += $vProp;
                $porMunicipio[$munCodigo]['votos_por_elec'][$eleccion->id]['comp']   += $vComp;
            }

            $porMunicipio[$munCodigo]['puestos'][$puestoId]['mesas'][] = [
                'numero'         => $mesa->numero_mesa,
                'testigo'        => $mesa->testigo->nombre ?? null,
                'reportada'      => $mesaAlgunaReport,
                'votos_por_elec' => $mesaVotosElec,
            ];

            $porMunicipio[$munCodigo]['puestos'][$puestoId]['mesas_reportadas'] += $mesaAlgunaReport ? 1 : 0;
            $porMunicipio[$munCodigo]['mesas_reportadas']                       += $mesaAlgunaReport ? 1 : 0;
            $porMunicipio[$munCodigo]['total_mesas']                            += 1;
        }

        uasort($porMunicipio, fn($a, $b) => strcmp($a['nombre'], $b['nombre']));

        $municipios = Puesto::select('municipio_codigo', 'municipio_nombre')
            ->distinct()
            ->orderBy('municipio_nombre')
            ->get();

        return view('resultados.index', compact(
            'elecciones',
            'totalVotosPropio', 'totalVotosCompetencia', 'totalVotos',
            'mesasReportadas', 'totalMesas',
            'porMunicipio', 'municipios', 'municipioFiltro'
        ));
    }

    /**
     * Obtener datos para gráficos via AJAX
     */
    public function chartData(Request $request)
    {
        $type = $request->get('type');

        switch ($type) {
            case 'personas_por_estado':
                $data = Persona::selectRaw('estado, COUNT(*) as total')
                              ->groupBy('estado')
                              ->get();
                break;
            
            case 'puestos_por_zona':
                $data = Puesto::selectRaw('zona, COUNT(*) as total')
                              ->groupBy('zona')
                              ->orderBy('zona')
                              ->get();
                break;
            
            case 'testigos_por_zona':
                $data = Testigo::selectRaw('fk_id_zona as zona, COUNT(*) as total')
                               ->groupBy('fk_id_zona')
                               ->orderBy('fk_id_zona')
                               ->get();
                break;
            
            default:
                $data = [];
        }

        return response()->json($data);
    }

    /**
     * Resumen de estadísticas
     */
    public function estadisticas()
    {
        $estadisticas = [
            'resumen_general' => [
                'personas' => Persona::count(),
                'puestos' => Puesto::count(),
                'mesas' => Puesto::sum('total_mesas') ?? 0,
                'testigos' => Testigo::count(),
                'coordinadores' => InfoElectoral::coordinadores()->count(),
                'lideres' => InfoElectoral::lideres()->count(),
            ],
            'por_zona' => Puesto::selectRaw('zona, COUNT(*) as puestos, 
                                           (SELECT COUNT(*) FROM testigos WHERE fk_id_zona = puestos.zona) as testigos')
                                ->groupBy('zona')
                                ->orderBy('zona')
                                ->get(),
            'personas_activas' => Persona::where('estado', 'activo')->count(),
            'personas_inactivas' => Persona::where('estado', '!=', 'activo')
                                          ->orWhereNull('estado')
                                          ->count(),
        ];

        return view('estadisticas', compact('estadisticas'));
    }

    /**
     * Panel de Municipios Estratégicos con datos por elección
     */
    public function municipiosEstrategicos()
    {
        $nombresMunicipios = ['CUCUTA', 'OCAÑA', 'LOS PATIOS', 'VILLA DEL ROSARIO', 'PAMPLONA', 'EL ZULIA'];
        $coloresMunicipios = [
            'CUCUTA'            => '#ef4444',
            'OCAÑA'             => '#3b82f6',
            'LOS PATIOS'        => '#10b981',
            'VILLA DEL ROSARIO' => '#8b5cf6',
            'PAMPLONA'          => '#f59e0b',
            'EL ZULIA'          => '#06b6d4',
        ];

        $elecciones = Eleccion::orderBy('fecha')->get();

        $municipios = collect();

        foreach ($nombresMunicipios as $nombre) {
            $puestos    = Puesto::where('municipio_nombre', 'LIKE', "%{$nombre}%")->get();
            $puestoIds  = $puestos->pluck('id');
            $mesaIds    = Mesa::whereIn('puesto_id', $puestoIds)->pluck('id');

            $totalMesasMun    = (int) $puestos->sum('total_mesas');
            $mesasAsignadas   = Mesa::whereIn('puesto_id', $puestoIds)->count();
            $testigosMun      = Testigo::whereIn('fk_id_puesto', $puestos->pluck('puesto'))->count();
            $mesasReportadas  = ResultadoMesa::whereIn('mesa_id', $mesaIds)->distinct('mesa_id')->count('mesa_id');

            // Ranking por elección para este municipio
            $rankingPorEleccion = [];
            foreach ($elecciones as $eleccion) {
                $resultadoIds = ResultadoMesa::whereIn('mesa_id', $mesaIds)
                    ->where('eleccion_id', $eleccion->id)
                    ->pluck('id');

                $ranking = DB::table('candidatos')
                    ->leftJoin('votos_candidatos', function ($join) use ($resultadoIds) {
                        $join->on('candidatos.id', '=', 'votos_candidatos.candidato_id')
                             ->whereIn('votos_candidatos.resultado_mesa_id', $resultadoIds);
                    })
                    ->where('candidatos.eleccion_id', $eleccion->id)
                    ->where('candidatos.activo', true)
                    ->select(
                        'candidatos.id',
                        'candidatos.nombre',
                        'candidatos.tipo',
                        'candidatos.orden',
                        DB::raw('COALESCE(SUM(votos_candidatos.votos), 0) as total_votos')
                    )
                    ->groupBy('candidatos.id', 'candidatos.nombre', 'candidatos.tipo', 'candidatos.orden')
                    ->orderByDesc('total_votos')
                    ->orderBy('candidatos.orden')
                    ->get();

                $rankingPorEleccion[$eleccion->id] = [
                    'eleccion'     => $eleccion,
                    'ranking'      => $ranking,
                    'votos_propio' => (int) $ranking->where('tipo', 'propio')->sum('total_votos'),
                ];
            }

            $municipios->push((object) [
                'nombre'              => $nombre,
                'color'               => $coloresMunicipios[$nombre],
                'total_puestos'       => $puestos->count(),
                'total_mesas'         => $totalMesasMun,
                'mesas_asignadas'     => $mesasAsignadas,
                'testigos'            => $testigosMun,
                'mesas_reportadas'    => $mesasReportadas,
                'ranking_por_eleccion'=> $rankingPorEleccion,
            ]);
        }

        return view('municipios.index', compact('municipios', 'elecciones'));
    }

    /**
     * Obtener estadísticas actualizadas para polling en tiempo real
     */
    public function getStats()
    {
        // Estadísticas de votos
        $totalVotosReportados = ResultadoMesa::sum('total_votos') ?? 0;
        $totalVotosCompetencia = ResultadoMesa::sum('votos_competencia') ?? 0;
        $mesasReportadas = ResultadoMesa::distinct('mesa_id')->count('mesa_id');
        $totalReportes = ResultadoMesa::count();
        
        // Mesas
        $totalMesas = Puesto::sum('total_mesas') ?? 0;
        $mesasCubiertas = $this->_mesasCubiertas();
        $mesasSinReportar = $mesasCubiertas - $mesasReportadas;
        
        // Últimos reportes
        $ultimosReportes = ResultadoMesa::with(['mesa.puesto', 'testigo'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function($reporte) {
                return [
                    'id' => $reporte->id,
                    'mesa_numero' => $reporte->mesa->numero_mesa ?? 'N/A',
                    'puesto_nombre' => $reporte->mesa->puesto->nombre ?? 'N/A',
                    'testigo_nombre' => $reporte->testigo->nombre ?? 'N/A',
                    'total_votos' => $reporte->total_votos,
                    'imagen_acta' => $reporte->imagen_acta,
                    'created_at' => $reporte->created_at->format('d/m/Y H:i'),
                    'created_at_timestamp' => $reporte->created_at->timestamp,
                ];
            });

        // Municipios destacados
        $nombresMunicipios = ['CUCUTA', 'OCAÑA', 'LOS PATIOS', 'VILLA DEL ROSARIO', 'PAMPLONA', 'EL ZULIA'];
        $coloresMunicipios = [
            'CUCUTA' => '#ef4444',
            'OCAÑA' => '#3b82f6',
            'LOS PATIOS' => '#10b981',
            'VILLA DEL ROSARIO' => '#8b5cf6',
            'PAMPLONA' => '#f59e0b',
            'EL ZULIA' => '#06b6d4',
        ];

        $municipiosDestacados = [];
        foreach ($nombresMunicipios as $nombreMunicipio) {
            $puestosMunicipio = Puesto::where('municipio_nombre', 'LIKE', "%{$nombreMunicipio}%")->get();
            $puestoIds = $puestosMunicipio->pluck('id');

            $totalMesasMun = $puestosMunicipio->sum('total_mesas') ?? 0;
            $mesasAsignadasMun = Mesa::whereIn('puesto_id', $puestoIds)->count();
            $testigosMun = Testigo::whereIn('fk_id_puesto', $puestosMunicipio->pluck('puesto'))->count();

            $mesaIds = Mesa::whereIn('puesto_id', $puestoIds)->pluck('id');
            $reportesMun = ResultadoMesa::whereIn('mesa_id', $mesaIds);
            $mesasReportadasMun = (clone $reportesMun)->distinct('mesa_id')->count('mesa_id');
            $votosCandidatoMun = (clone $reportesMun)->sum('total_votos') ?? 0;
            $votosCompetenciaMun = (clone $reportesMun)->sum('votos_competencia') ?? 0;

            $municipiosDestacados[] = [
                'nombre' => $nombreMunicipio,
                'color' => $coloresMunicipios[$nombreMunicipio],
                'total_puestos' => $puestosMunicipio->count(),
                'total_mesas' => $totalMesasMun,
                'mesas_asignadas' => $mesasAsignadasMun,
                'testigos' => $testigosMun,
                'mesas_reportadas' => $mesasReportadasMun,
                'votos_candidato' => $votosCandidatoMun,
                'votos_competencia' => $votosCompetenciaMun,
            ];
        }

        return response()->json([
            'totalVotosReportados' => $totalVotosReportados,
            'totalVotosCompetencia' => $totalVotosCompetencia,
            'mesasReportadas' => $mesasReportadas,
            'mesasSinReportar' => $mesasSinReportar,
            'totalReportes' => $totalReportes,
            'totalMesas' => $totalMesas,
            'mesasCubiertas' => $mesasCubiertas,
            'ultimosReportes' => $ultimosReportes,
            'municipiosDestacados' => $municipiosDestacados,
            'timestamp' => now()->timestamp,
        ]);
    }

    /**
     * Panel visor para TV/pantalla en tiempo real
     */
    public function visor()
    {
        $elecciones = $this->_eleccionesConVotos();
        $totalTestigos  = Testigo::count();
        $totalPuestos   = Puesto::count();
        $totalMesas     = Puesto::sum('total_mesas') ?? 0;
        $mesasCubiertas = $this->_mesasCubiertas();
        $mesasReportadas = ResultadoMesa::distinct('mesa_id')->count('mesa_id');

        $ultimosReportes = ResultadoMesa::with(['mesa.puesto', 'eleccion'])
            ->latest()->take(20)->get();

        $ultimosReportesPorEleccion = Eleccion::orderBy('fecha')->get()->map(function ($eleccion) {
            $eleccion->ultimosReportes = ResultadoMesa::with(['mesa.puesto'])
                ->where('eleccion_id', $eleccion->id)
                ->latest()->take(10)->get();
            return $eleccion;
        });

        return view('visor', compact(
            'elecciones',
            'totalTestigos', 'totalPuestos', 'totalMesas',
            'mesasCubiertas', 'mesasReportadas',
            'ultimosReportes', 'ultimosReportesPorEleccion'
        ));
    }

    /**
     * JSON para el polling del visor (cada 20s)
     */
    public function visorData()
    {
        $mesasCubiertas = $this->_mesasCubiertas();

        $elecciones = $this->_eleccionesConVotos()->map(fn($e) => [
            'id'                  => $e->id,
            'nombre'              => $e->nombre,
            'color'               => $e->color,
            'votos_propio'        => $e->votos_propio,
            'votos_competencia'   => $e->votos_competencia,
            'mesas_reportadas'    => $e->mesas_reportadas_elec,
            'mesas_cubiertas'     => $mesasCubiertas,
            'candidatos'          => $e->candidatos_ranking->map(fn($c) => [
                'id'          => $c->id,
                'nombre'      => $c->nombre,
                'tipo'        => $c->tipo,
                'total_votos' => (int) $c->total_votos,
            ])->values(),
        ]);

        $ultimosReportes = ResultadoMesa::with(['mesa.puesto', 'eleccion'])
            ->latest()->take(20)->get()->map(fn($r) => [
                'mesa'           => $r->mesa->numero_mesa ?? '?',
                'puesto'         => $r->mesa?->puesto?->nombre ?? '—',
                'municipio'      => $r->mesa?->puesto?->municipio_nombre ?? '',
                'eleccion_nombre'=> $r->eleccion?->nombre ?? '—',
                'eleccion_color' => $r->eleccion?->color ?? '#667eea',
                'total_votos'    => (int) ($r->total_votos ?? 0),
                'tiene_foto'     => !empty($r->imagen_acta),
                'tiempo'         => $r->updated_at->diffForHumans(),
            ]);

        $reportesPorEleccion = Eleccion::orderBy('fecha')->get()->map(fn($elec) => [
            'id'     => $elec->id,
            'nombre' => $elec->nombre,
            'color'  => $elec->color,
            'tipo_cargo' => $elec->tipo_cargo,
            'fecha'  => $elec->fecha?->format('d/m/Y'),
            'reportes' => ResultadoMesa::with(['mesa.puesto'])
                ->where('eleccion_id', $elec->id)
                ->latest()->take(10)->get()
                ->map(fn($r) => [
                    'mesa'       => $r->mesa->numero_mesa ?? '?',
                    'puesto'     => $r->mesa?->puesto?->nombre ?? '—',
                    'testigo'    => 'N/A',
                    'total_votos'=> (int)($r->total_votos ?? 0),
                    'imagen_acta'=> $r->imagen_acta ?? [],
                    'fecha'      => $r->created_at->format('d/m/Y H:i'),
                ])->values(),
        ]);

        return response()->json([
            'elecciones'          => $elecciones,
            'mesasCubiertas'      => $mesasCubiertas,
            'mesasReportadas'     => ResultadoMesa::distinct('mesa_id')->count('mesa_id'),
            'totalMesas'          => Puesto::sum('total_mesas') ?? 0,
            'totalTestigos'       => Testigo::count(),
            'totalPuestos'        => Puesto::count(),
            'ultimosReportes'     => $ultimosReportes,
            'reportesPorEleccion' => $reportesPorEleccion,
            'hora'                => now()->format('H:i:s'),
        ]);
    }

    /**
     * Helper: mesas cubiertas = mesas en puestos con coordinador
     *         + mesas de testigos en puestos SIN coordinador
     */
    private function _mesasCubiertas(): int
    {
        $puestosConCoord = Coordinador::distinct()->pluck('fk_id_puesto');
        return (int) Puesto::whereIn('id', $puestosConCoord)->sum('total_mesas')
             + Mesa::whereNotIn('puesto_id', $puestosConCoord)->count();
    }

    /** Helper interno: elecciones con votos, ranking de candidatos y mesas_reportadas_elec */
    private function _eleccionesConVotos()
    {
        return Eleccion::orderBy('fecha')->get()->map(function ($eleccion) {
            // Totales por tipo
            $resumen = DB::table('candidatos')
                ->leftJoin('votos_candidatos', 'candidatos.id', '=', 'votos_candidatos.candidato_id')
                ->where('candidatos.eleccion_id', $eleccion->id)
                ->select('candidatos.tipo', DB::raw('COALESCE(SUM(votos_candidatos.votos), 0) as total_votos'))
                ->groupBy('candidatos.tipo')->get()->keyBy('tipo');

            $eleccion->votos_propio          = (int) ($resumen['propio']->total_votos      ?? 0);
            $eleccion->votos_competencia     = (int) ($resumen['competencia']->total_votos ?? 0);
            $eleccion->mesas_reportadas_elec = ResultadoMesa::where('eleccion_id', $eleccion->id)
                ->distinct('mesa_id')->count('mesa_id');

            // Ranking completo de candidatos con sus votos
            $eleccion->candidatos_ranking = DB::table('candidatos')
                ->leftJoin('votos_candidatos', 'candidatos.id', '=', 'votos_candidatos.candidato_id')
                ->where('candidatos.eleccion_id', $eleccion->id)
                ->where('candidatos.activo', true)
                ->select(
                    'candidatos.id',
                    'candidatos.nombre',
                    'candidatos.tipo',
                    DB::raw('COALESCE(SUM(votos_candidatos.votos), 0) as total_votos')
                )
                ->groupBy('candidatos.id', 'candidatos.nombre', 'candidatos.tipo')
                ->orderByDesc('total_votos')
                ->get();

            return $eleccion;
        });
    }
}