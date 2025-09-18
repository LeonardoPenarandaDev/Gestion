<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PuestoController extends Controller
{
    /**
     * Mostrar lista de puestos
     */
    public function index()
    {
        $puestos = Puesto::with(['testigos', 'infoElectoral'])
                        ->orderBy('zona')
                        ->orderBy('puesto')
                        ->paginate(15);
        return view('puestos.index', compact('puestos'));
    }

    /**
     * Mostrar formulario para crear nuevo puesto
     */
    public function create()
    {
        return view('puestos.create');
    }

    /**
     * Guardar nuevo puesto
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zona' => 'required|string|max:2',
            'puesto' => 'required|string|max:2',
            'nombre' => 'required|string|max:200',
            'direccion' => 'required|string|max:200',
            'total_mesas' => 'nullable|integer|min:0',
            'alias' => 'nullable|string|max:20'
        ], [
            'zona.required' => 'La zona es obligatoria',
            'puesto.required' => 'El puesto es obligatorio',
            'nombre.required' => 'El nombre es obligatorio',
            'direccion.required' => 'La dirección es obligatoria',
            'total_mesas.integer' => 'El total de mesas debe ser un número entero',
            'total_mesas.min' => 'El total de mesas no puede ser negativo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        Puesto::create($request->all());

        return redirect()->route('puestos.index')
                        ->with('success', 'Puesto creado exitosamente.');
    }

    /**
     * Mostrar detalles de un puesto
     */
    public function show(Puesto $puesto)
    {
        $puesto->load(['testigos', 'infoElectoral', 'infoTestigo']);
        return view('puestos.show', compact('puesto'));
    }

    /**
     * Mostrar formulario para editar puesto
     */
    public function edit(Puesto $puesto)
    {
        return view('puestos.edit', compact('puesto'));
    }

    /**
     * Actualizar puesto
     */
    public function update(Request $request, Puesto $puesto)
    {
        $validator = Validator::make($request->all(), [
            'zona' => 'required|string|max:2',
            'puesto' => 'required|string|max:2',
            'nombre' => 'required|string|max:200',
            'direccion' => 'required|string|max:200',
            'total_mesas' => 'nullable|integer|min:0',
            'alias' => 'nullable|string|max:20'
        ], [
            'zona.required' => 'La zona es obligatoria',
            'puesto.required' => 'El puesto es obligatorio',
            'nombre.required' => 'El nombre es obligatorio',
            'direccion.required' => 'La dirección es obligatoria',
            'total_mesas.integer' => 'El total de mesas debe ser un número entero',
            'total_mesas.min' => 'El total de mesas no puede ser negativo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $puesto->update($request->all());

        return redirect()->route('puestos.index')
                        ->with('success', 'Puesto actualizado exitosamente.');
    }

    /**
     * Eliminar puesto
     */
    public function destroy(Puesto $puesto)
    {
        try {
            $puesto->delete();
            return redirect()->route('puestos.index')
                            ->with('success', 'Puesto eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('puestos.index')
                            ->with('error', 'No se pudo eliminar el puesto. Puede estar relacionado con otros registros.');
        }
    }
}