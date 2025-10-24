<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Puesto;
use App\Models\Testigo;
use App\Models\InfoElectoral;
use App\Models\InfoTestigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal
     */
    public function index()
    {
        // Estadísticas generales
        $totalPersonas = Persona::count();
        $totalPuestos = Puesto::count();
        
        // Total de mesas (suma del campo total_mesas de la tabla puestos)
        $mesas = Puesto::sum('total_mesas') ?? 0;
        
        // Mesas cubiertas (testigos asignados)
        $Mesas = Testigo::whereNotNull('fk_id_puesto')->count();
        
        $totalTestigos = Testigo::count();
        $totalCoordinadores = InfoElectoral::coordinadores()->count();
        $totalLideres = InfoElectoral::lideres()->count();

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
            'mesas',           // Total de mesas (suma)
            'Mesas',           // Mesas cubiertas (testigos asignados)
            'totalTestigos',
            'totalCoordinadores',
            'totalLideres',
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