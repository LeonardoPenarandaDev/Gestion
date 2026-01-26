<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{
    /**
     * Middleware para bloquear acceso a testigos
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->isTestigo()) {
                abort(403, 'No tiene permisos para acceder a esta sección.');
            }
            return $next($request);
        });
    }

    /**
     * Mostrar lista de personas
     */
    public function index()
    {
        $personas = Persona::with(['infoElectoralCoordinador', 'infoElectoralLider'])
                          ->paginate(15);
        return view('personas.index', compact('personas'));
    }

    /**
     * Mostrar formulario para crear nueva persona
     */
    public function create()
    {
        return view('personas.create');
    }

    /**
     * Guardar nueva persona
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identificacion' => 'required|string|max:20|unique:personas',
            'nombre' => 'nullable|string|max:70',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'email' => 'nullable|email|max:80',
            'ocupacion' => 'nullable|string|max:200',
            'fecha_ingreso' => 'nullable|date',
            'estado' => 'nullable|string|max:50'
        ], [
            'identificacion.required' => 'La identificación es obligatoria',
            'identificacion.unique' => 'Ya existe una persona con esta identificación',
            'email.email' => 'El email debe tener un formato válido'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        Persona::create($request->all());

        return redirect()->route('personas.index')
                        ->with('success', 'Persona creada exitosamente.');
    }

    /**
     * Mostrar detalles de una persona
     */
    public function show(Persona $persona)
    {
        $persona->load(['infoElectoralCoordinador', 'infoElectoralLider']);
        return view('personas.show', compact('persona'));
    }

    /**
     * Mostrar formulario para editar persona
     */
    public function edit(Persona $persona)
    {
        return view('personas.edit', compact('persona'));
    }

    /**
     * Actualizar persona
     */
    public function update(Request $request, Persona $persona)
    {
        $validator = Validator::make($request->all(), [
            'identificacion' => 'required|string|max:20|unique:personas,identificacion,'.$persona->id,
            'nombre' => 'nullable|string|max:70',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'email' => 'nullable|email|max:80',
            'ocupacion' => 'nullable|string|max:200',
            'fecha_ingreso' => 'nullable|date',
            'estado' => 'nullable|string|max:50'
        ], [
            'identificacion.required' => 'La identificación es obligatoria',
            'name.required' => 'El nombre es obligatorio',
            'identificacion.unique' => 'Ya existe una persona con esta identificación',
            'email.email' => 'El email debe tener un formato válido'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $persona->update($request->all());

        return redirect()->route('personas.index')
                        ->with('success', 'Persona actualizada exitosamente.');
    }

    /**
     * Eliminar persona
     */
    public function destroy(Persona $persona)
    {
        if (!auth()->user()->canDelete()) {
            return redirect()->route('personas.index')->with('error', 'No tienes permisos para eliminar registros.');
        }

        try {
            $persona->delete();
            return redirect()->route('personas.index')
                            ->with('success', 'Persona eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('personas.index')
                            ->with('error', 'No se pudo eliminar la persona. Puede estar relacionada con otros registros.');
        }
    }
}