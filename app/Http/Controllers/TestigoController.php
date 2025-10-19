<?php

namespace App\Http\Controllers;

use App\Models\Testigo;
use App\Models\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestigoController extends Controller
{
    /**
     * Mostrar lista de testigos
     */
    public function index()
    {
        $testigos = Testigo::with(['puesto', 'infoElectoral', 'infoTestigo'])
                          ->paginate(15);
        return view('testigos.index', compact('testigos'));
    }

    /**
     * Mostrar formulario para crear nuevo testigo
     */
    public function create()
    {
        // Obtener todas las zonas únicas (números)
        $zonas = Puesto::select('zona')
            ->distinct()
            ->orderBy('zona')
            ->get();
        
        // Obtener puestos agrupados por zona con información completa
        $puestosPorZona = [];
        
        foreach ($zonas as $zona) {
            // Usar el número de zona como clave
            $zonaNumero = (string)$zona->zona;
            
            $puestosPorZona[$zonaNumero] = Puesto::where('zona', $zona->zona)
                ->select('id', 'puesto', 'nombre', 'direccion', 'total_mesas', 'zona')
                ->orderBy('puesto')
                ->get()
                ->map(function($puesto) {
                    return [
                        'id' => $puesto->id,
                        'puesto' => $puesto->puesto,
                        'nombre' => $puesto->nombre ?? 'Sin nombre',
                        'direccion' => $puesto->direccion ?? 'Sin dirección',
                        'total_mesas' => $puesto->total_mesas ?? 0,
                    ];
                })
                ->toArray();
        }
        
        return view('testigos.create', [
            'zonas' => $zonas,
            'puestosPorZona' => $puestosPorZona,
        ]);
    }

    /**
     * Guardar nuevo testigo
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_id_zona' => 'required|string|max:50',
            'fk_id_puesto' => 'required|exists:puesto,id',
            'documento' => 'required|string|max:20|unique:testigo,documento',
            'nombre' => 'required|string|max:30',
            'mesas' => 'required|integer|min:1',
            'alias' => 'nullable|string|max:20'
        ], [
            'fk_id_zona.required' => 'La zona es obligatoria',
            'fk_id_puesto.required' => 'El puesto es obligatorio',
            'fk_id_puesto.exists' => 'El puesto seleccionado no existe',
            'documento.required' => 'El documento es obligatorio',
            'documento.unique' => 'Este documento ya está registrado',
            'nombre.required' => 'El nombre es obligatorio',
            'mesas.required' => 'El número de mesas es obligatorio',
            'mesas.min' => 'Debe asignar al menos 1 mesa',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            Testigo::create($request->all());
            return redirect()->route('testigos.index')
                            ->with('success', 'Testigo creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withErrors(['error' => 'Error al crear el testigo: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    /**
     * Mostrar detalles de un testigo
     */
    public function show(Testigo $testigo)
    {
        $testigo->load(['puesto', 'infoElectoral', 'infoTestigo']);
        return view('testigos.show', compact('testigo'));
    }

    /**
     * Mostrar formulario para editar testigo
     */
    public function edit(Testigo $testigo)
    {
        // Obtener todas las zonas únicas
        $zonas = Puesto::select('zona')
            ->distinct()
            ->orderBy('zona')
            ->get();
        
        // Obtener puestos agrupados por zona
        $puestosPorZona = [];
        
        foreach ($zonas as $zona) {
            $zonaNumero = (string)$zona->zona;
            
            $puestosPorZona[$zonaNumero] = Puesto::where('zona', $zona->zona)
                ->select('id', 'puesto', 'nombre', 'direccion', 'total_mesas', 'zona')
                ->orderBy('puesto')
                ->get()
                ->map(function($puesto) {
                    return [
                        'id' => $puesto->id,
                        'puesto' => $puesto->puesto,
                        'nombre' => $puesto->nombre ?? 'Sin nombre',
                        'direccion' => $puesto->direccion ?? 'Sin dirección',
                        'total_mesas' => $puesto->total_mesas ?? 0,
                    ];
                })
                ->toArray();
        }
        
        return view('testigos.edit', [
            'testigo' => $testigo,
            'zonas' => $zonas,
            'puestosPorZona' => $puestosPorZona,
        ]);
    }

    /**
     * Actualizar testigo
     */
    public function update(Request $request, Testigo $testigo)
    {
        $validator = Validator::make($request->all(), [
            'fk_id_zona' => 'required|string|max:50',
            'fk_id_puesto' => 'required|exists:puesto,id',
            'documento' => 'required|string|max:20|unique:testigo,documento,' . $testigo->id,
            'nombre' => 'required|string|max:30',
            'mesas' => 'required|integer|min:1',
            'alias' => 'nullable|string|max:20'
        ], [
            'fk_id_zona.required' => 'La zona es obligatoria',
            'fk_id_puesto.required' => 'El puesto es obligatorio',
            'fk_id_puesto.exists' => 'El puesto seleccionado no existe',
            'documento.required' => 'El documento es obligatorio',
            'documento.unique' => 'Este documento ya está registrado',
            'nombre.required' => 'El nombre es obligatorio',
            'mesas.required' => 'El número de mesas es obligatorio',
            'mesas.min' => 'Debe asignar al menos 1 mesa',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $testigo->update($request->all());
            return redirect()->route('testigos.index')
                            ->with('success', 'Testigo actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withErrors(['error' => 'Error al actualizar el testigo: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    /**
     * Eliminar testigo
     */
    public function destroy(Testigo $testigo)
    {
        try {
            $testigo->delete();
            return redirect()->route('testigos.index')
                            ->with('success', 'Testigo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('testigos.index')
                            ->with('error', 'No se pudo eliminar el testigo. Puede estar relacionado con otros registros.');
        }
    }
}