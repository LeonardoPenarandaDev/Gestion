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

        // Estadísticas de reportes de votos
        $totalReportes = ResultadoMesa::count();
        $totalVotosReportados = ResultadoMesa::sum('total_votos') ?? 0;
        $mesasReportadas = ResultadoMesa::distinct('mesa_id')->count('mesa_id');
        $mesasSinReportar = $mesasCubiertas - $mesasReportadas;

        // Últimos reportes
        $ultimosReportes = ResultadoMesa::with(['mesa.puesto', 'testigo'])
            ->latest()
            ->take(10)
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
            'mesasReportadas',
            'mesasSinReportar',
            'ultimosReportes',
            'personasPorEstado',
            'puestosPorZona',
            'testigosPorZona',
            'personasRecientes',
            'puestosConMasTestigos'
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
}