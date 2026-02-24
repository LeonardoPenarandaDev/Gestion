<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Puesto;
use App\Models\Testigo;
use App\Models\InfoElectoral;
use App\Models\InfoTestigo;
use App\Models\Mesa;
use App\Models\ResultadoMesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal
     */
    public function index()
    {
        // Redirigir testigos a su portal
        if (auth()->user()->isTestigo()) {
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

        // Mesas cubiertas/asignadas a testigos
        $mesasCubiertas = Mesa::count();

        $totalTestigos = Testigo::count();
        $totalCoordinadores = InfoElectoral::coordinadores()->count();
        $totalLideres = InfoElectoral::lideres()->count();
        
        // Mesas pendientes
        $totalMesasPendientes = max(0, $totalMesas - $mesasCubiertas);

        // Municipios estratégicos destacados
        $nombresMunicipios = ['CUCUTA', 'OCAÑA', 'LOS PATIOS', 'VILLA DEL ROSARIO', 'PAMPLONA', 'EL ZULIA'];
        $coloresMunicipios = [
            'CUCUTA' => '#ef4444',
            'OCAÑA' => '#3b82f6',
            'LOS PATIOS' => '#10b981',
            'VILLA DEL ROSARIO' => '#8b5cf6',
            'PAMPLONA' => '#f59e0b',
            'EL ZULIA' => '#06b6d4',
        ];

        $municipiosDestacados = collect();
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

            $municipiosDestacados->push((object) [
                'nombre' => $nombreMunicipio,
                'color' => $coloresMunicipios[$nombreMunicipio],
                'total_puestos' => $puestosMunicipio->count(),
                'total_mesas' => $totalMesasMun,
                'mesas_asignadas' => $mesasAsignadasMun,
                'testigos' => $testigosMun,
                'mesas_reportadas' => $mesasReportadasMun,
                'votos_candidato' => $votosCandidatoMun,
                'votos_competencia' => $votosCompetenciaMun,
            ]);
        }

        // Estadísticas de reportes de votos
        $totalReportes = ResultadoMesa::count();
        $totalVotosReportados = ResultadoMesa::sum('total_votos') ?? 0;
        $totalVotosCompetencia = ResultadoMesa::sum('votos_competencia') ?? 0;
        $mesasReportadas = ResultadoMesa::distinct('mesa_id')->count('mesa_id');
        $mesasSinReportar = $mesasCubiertas - $mesasReportadas;

        // Últimos reportes
        $ultimosReportes = ResultadoMesa::with(['mesa.puesto', 'testigo'])
            ->latest()
            ->take(10)
            ->get();

        // Votos por municipio
        $votosPorMunicipio = DB::table('resultados_mesas')
            ->join('mesas', 'resultados_mesas.mesa_id', '=', 'mesas.id')
            ->join('puesto', 'mesas.puesto_id', '=', 'puesto.id')
            ->select(
                'puesto.municipio_codigo',
                'puesto.municipio_nombre',
                DB::raw('COUNT(DISTINCT puesto.id) as puestos_con_reportes'),
                DB::raw('COUNT(DISTINCT resultados_mesas.mesa_id) as mesas_reportadas'),
                DB::raw('SUM(resultados_mesas.total_votos) as total_votos'),
                DB::raw('SUM(resultados_mesas.votos_competencia) as votos_competencia')
            )
            ->groupBy('puesto.municipio_codigo', 'puesto.municipio_nombre')
            ->orderByDesc('total_votos')
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

        // Votos por mesa (todas las mesas con sus votos)
        $votosPorMesa = DB::table('mesas')
            ->join('puesto', 'mesas.puesto_id', '=', 'puesto.id')
            ->leftJoin('resultados_mesas', 'mesas.id', '=', 'resultados_mesas.mesa_id')
            ->select(
                'mesas.id',
                'mesas.numero_mesa',
                'puesto.nombre as puesto_nombre',
                'puesto.zona',
                DB::raw('COALESCE(resultados_mesas.total_votos, 0) as total_votos'),
                DB::raw('COALESCE(resultados_mesas.votos_competencia, 0) as votos_competencia'),
                DB::raw('CASE WHEN resultados_mesas.id IS NOT NULL THEN 1 ELSE 0 END as tiene_reporte')
            )
            ->orderBy('puesto.zona')
            ->orderBy('puesto.nombre')
            ->orderBy('mesas.numero_mesa')
            ->get();

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
            'personasPorEstado',
            'puestosPorZona',
            'testigosPorZona',
            'personasRecientes',
            'puestosConMasTestigos',
            'votosPorMunicipio',
            'votosPorPuesto',
            'votosPorMesa',
            'municipiosDestacados'
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
        $mesasCubiertas = Mesa::count();
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
}