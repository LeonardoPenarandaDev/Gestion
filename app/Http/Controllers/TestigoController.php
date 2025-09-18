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
        $puestos = Puesto::orderBy('zona')->orderBy('puesto')->get();
        $zonas = Puesto::select('zona')->distinct()->orderBy('zona')->get();
        return view('testigos.create', compact('puestos', 'zonas'));
    }

    /**
     * Guardar nuevo testigo
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_id_zona' => 'required|string|max:2',
            'fk_id_puesto' => 'required|exists:puesto,id',
            'mesas' => 'nullable|integer|min:0',
            'alias' => 'nullable|string|max:20'
        ], [
            'fk_id_zona.required' => 'La zona es obligatoria',
            'fk_id_puesto.required' => 'El puesto es obligatorio',
            'fk_id_puesto.exists' => 'El puesto seleccionado no existe',
            'mesas.integer' => 'El número de mesas debe ser un entero',
            'mesas.min' => 'El número de mesas no puede ser negativo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        Testigo::create($request->all());

        return redirect()->route('testigos.index')
                        ->with('success', 'Testigo creado exitosamente.');
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
        $puestos = Puesto::orderBy('zona')->orderBy('puesto')->get();
        $zonas = Puesto::select('zona')->distinct()->orderBy('zona')->get();
        return view('testigos.edit', compact('testigo', 'puestos', 'zonas'));
    }

    /**
     * Actualizar testigo
     */
    public function update(Request $request, Testigo $testigo)
    {
        $validator = Validator::make($request->all(), [
            'fk_id_zona' => 'required|string|max:2',
            'fk_id_puesto' => 'required|exists:puesto,id',
            'mesas' => 'nullable|integer|min:0',
            'alias' => 'nullable|string|max:20'
        ], [
            'fk_id_zona.required' => 'La zona es obligatoria',
            'fk_id_puesto.required' => 'El puesto es obligatorio',
            'fk_id_puesto.exists' => 'El puesto seleccionado no existe',
            'mesas.integer' => 'El número de mesas debe ser un entero',
            'mesas.min' => 'El número de mesas no puede ser negativo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $testigo->update($request->all());

        return redirect()->route('testigos.index')
                        ->with('success', 'Testigo actualizado exitosamente.');
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