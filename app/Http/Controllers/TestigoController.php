<?php

namespace App\Http\Controllers;

use App\Models\Testigo;
use App\Models\Puesto;
use App\Models\Mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestigoController extends Controller
{
    /**
     * Mostrar lista de testigos
     */
    public function index()
    {
        $testigos = Testigo::with(['puesto', 'mesas'])
                          ->paginate(15);

        // Calcular contadores para el dashboard
        $totalMesas = Puesto::sum('total_mesas'); // Total de mesas disponibles según los puestos
        $mesasCubiertas = Mesa::count(); // Total de mesas cubiertas (asignadas a testigos)

        return view('testigos.index', compact('testigos', 'totalMesas', 'mesasCubiertas'));
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
                ->with(['mesas:puesto_id,numero_mesa']) // Eager load para obtener los números de mesa
                ->withCount('mesas')
                ->orderBy('puesto')
                ->get()
                ->map(function($puesto) {
                    return [
                        'id' => $puesto->id,
                        'puesto' => $puesto->puesto,
                        'nombre' => $puesto->nombre ?? 'Sin nombre',
                        'direccion' => $puesto->direccion ?? 'Sin dirección',
                        'total_mesas' => $puesto->total_mesas ?? 0,
                        'mesas_ocupadas' => $puesto->mesas_count ?? 0,
                        'mesas_ocupadas_ids' => $puesto->mesas->pluck('numero_mesa')->toArray(), // Array de mesas ocupadas
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
            'fk_id_zona' => 'required|string|max:10',
            'fk_id_puesto' => 'required|numeric|exists:puesto,id',
            'documento' => 'required|string|max:20|unique:testigo,documento',
            'nombre' => 'required|string|max:30',
            'mesas' => 'required|array|min:1',
            'mesas.*' => 'required|integer|min:1',
            'alias' => 'nullable|string|max:20'
        ], [
            'fk_id_zona.required' => 'La zona es obligatoria',
            'fk_id_zona.max' => 'La zona no puede exceder 10 caracteres',
            'fk_id_puesto.required' => 'El puesto es obligatorio',
            'fk_id_puesto.exists' => 'El puesto seleccionado no existe',
            'documento.required' => 'El documento es obligatorio',
            'documento.unique' => 'Este documento ya está registrado',
            'nombre.required' => 'El nombre es obligatorio',
            'mesas.required' => 'Debe seleccionar al menos una mesa',
            'mesas.min' => 'Debe asignar al menos 1 mesa',
            'mesas.*.integer' => 'Los números de mesa deben ser válidos',
            'mesas.*.min' => 'Los números de mesa deben ser mayores a 0',
        ]);

        // Validación adicional: verificar que las mesas estén dentro del rango del puesto
        $validator->after(function ($validator) use ($request) {
            if ($request->fk_id_puesto && $request->mesas) {
                $puesto = Puesto::find($request->fk_id_puesto);

                if ($puesto && $puesto->total_mesas) {
                    foreach ($request->mesas as $numeroMesa) {
                        if ($numeroMesa > $puesto->total_mesas) {
                            $validator->errors()->add(
                                'mesas',
                                "La mesa {$numeroMesa} excede el total de mesas disponibles ({$puesto->total_mesas}) en el puesto seleccionado."
                            );
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            DB::beginTransaction();
            
            // Crear el testigo
            $testigo = Testigo::create([
                'fk_id_zona' => $request->fk_id_zona,
                'fk_id_puesto' => $request->fk_id_puesto,
                'documento' => $request->documento,
                'nombre' => $request->nombre,
                'alias' => $request->alias ?? null
            ]);
            
            // Crear las mesas asociadas
            foreach ($request->mesas as $numeroMesa) {
                Mesa::create([
                    'testigo_id' => $testigo->id,
                    'puesto_id' => $request->fk_id_puesto,
                    'numero_mesa' => $numeroMesa,
                ]);
            }
            
            DB::commit();
            Log::info('Testigo creado exitosamente', ['testigo_id' => $testigo->id]);

            return redirect()->route('testigos.index')
                            ->with('success', 'Testigo creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear testigo', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
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
        $testigo->load(['puesto', 'mesas']);
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
            'fk_id_zona' => 'required|string|max:10',
            'fk_id_puesto' => 'required|exists:puesto,id',
            'documento' => 'required|string|max:20|unique:testigo,documento,' . $testigo->id,
            'nombre' => 'required|string|max:30',
            'mesas' => 'required|array|min:1',
            'mesas.*' => 'required|integer|min:1',
            'alias' => 'nullable|string|max:20'
        ], [
            'fk_id_zona.required' => 'La zona es obligatoria',
            'fk_id_zona.max' => 'La zona no puede exceder 10 caracteres',
            'fk_id_puesto.required' => 'El puesto es obligatorio',
            'fk_id_puesto.exists' => 'El puesto seleccionado no existe',
            'documento.required' => 'El documento es obligatorio',
            'documento.unique' => 'Este documento ya está registrado',
            'nombre.required' => 'El nombre es obligatorio',
            'mesas.required' => 'Debe seleccionar al menos una mesa',
            'mesas.min' => 'Debe asignar al menos 1 mesa',
            'mesas.*.integer' => 'Los números de mesa deben ser válidos',
            'mesas.*.min' => 'Los números de mesa deben ser mayores a 0',
        ]);

        // Validación adicional: verificar que las mesas estén dentro del rango del puesto
        $validator->after(function ($validator) use ($request) {
            if ($request->fk_id_puesto && $request->mesas) {
                $puesto = Puesto::find($request->fk_id_puesto);

                if ($puesto && $puesto->total_mesas) {
                    foreach ($request->mesas as $numeroMesa) {
                        if ($numeroMesa > $puesto->total_mesas) {
                            $validator->errors()->add(
                                'mesas',
                                "La mesa {$numeroMesa} excede el total de mesas disponibles ({$puesto->total_mesas}) en el puesto seleccionado."
                            );
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            DB::beginTransaction();
            
            // Actualizar datos del testigo
            $testigo->update([
                'fk_id_zona' => $request->fk_id_zona,
                'fk_id_puesto' => $request->fk_id_puesto,
                'documento' => $request->documento,
                'nombre' => $request->nombre,
                'alias' => $request->alias ?? null
            ]);
            
            // Sincronizar mesas: eliminar todas las existentes y crear las nuevas
            $testigo->mesas()->delete();
            
            foreach ($request->mesas as $numeroMesa) {
                Mesa::create([
                    'testigo_id' => $testigo->id,
                    'puesto_id' => $request->fk_id_puesto,
                    'numero_mesa' => $numeroMesa,
                ]);
            }
            
            DB::commit();
            return redirect()->route('testigos.index')
                            ->with('success', 'Testigo actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
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
        if (!auth()->user()->canDelete()) {
            return redirect()->route('testigos.index')->with('error', 'No tienes permisos para eliminar registros.');
        }

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