<?php

namespace App\Http\Controllers;

use App\Models\Coordinador;
use App\Models\Puesto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CoordinadorController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->isTestigo()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $coordinadores = Coordinador::with(['puesto', 'user'])->orderBy('nombre')->get();
        return view('coordinadores.index', compact('coordinadores'));
    }

    public function create()
    {
        $municipios = Puesto::select('municipio_codigo', 'municipio_nombre')
            ->distinct()->orderBy('municipio_nombre')->get();

        $puestosPorMunicipioZona = [];
        foreach ($municipios as $municipio) {
            $munCodigo = $municipio->municipio_codigo;
            $puestosPorMunicipioZona[$munCodigo] = [
                'nombre' => $municipio->municipio_nombre,
                'zonas'  => [],
            ];
            $zonas = Puesto::where('municipio_codigo', $munCodigo)
                ->select('zona')->distinct()->orderBy('zona')->get();

            foreach ($zonas as $zona) {
                $puestos = Puesto::where('municipio_codigo', $munCodigo)
                    ->where('zona', $zona->zona)
                    ->withCount('mesas')
                    ->orderBy('puesto')
                    ->get()
                    ->map(fn($p) => [
                        'id'          => $p->id,
                        'puesto'      => $p->puesto,
                        'nombre'      => $p->nombre ?? 'Sin nombre',
                        'direccion'   => $p->direccion ?? '',
                        'total_mesas' => $p->total_mesas ?? 0,
                    ])->toArray();

                $puestosPorMunicipioZona[$munCodigo]['zonas'][$zona->zona] = $puestos;
            }
        }

        return view('coordinadores.create', compact('municipios', 'puestosPorMunicipioZona'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fk_id_zona'  => 'required|string|max:10',
            'fk_id_puesto'=> 'required|numeric|exists:puesto,id',
            'documento'   => 'required|string|max:20|unique:coordinadores,documento',
            'nombre'      => 'required|string|max:60',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
        ], [
            'fk_id_zona.required'   => 'La zona es obligatoria',
            'fk_id_puesto.required' => 'El puesto es obligatorio',
            'fk_id_puesto.exists'   => 'El puesto seleccionado no existe',
            'documento.required'    => 'El documento es obligatorio',
            'documento.unique'      => 'Este documento ya está registrado',
            'nombre.required'       => 'El nombre es obligatorio',
            'email.required'        => 'El email es obligatorio',
            'email.unique'          => 'Este email ya está registrado',
            'password.required'     => 'La contraseña es obligatoria',
            'password.min'          => 'La contraseña debe tener al menos 6 caracteres',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name'             => $request->nombre,
                'email'            => $request->email,
                'password'         => Hash::make($request->password),
                'password_texto'   => $request->password,
                'role'             => 'coordinador',
                'email_verified_at'=> now(),
            ]);

            Coordinador::create([
                'user_id'      => $user->id,
                'fk_id_zona'   => $request->fk_id_zona,
                'fk_id_puesto' => $request->fk_id_puesto,
                'documento'    => $request->documento,
                'nombre'       => $request->nombre,
            ]);

            DB::commit();

            return redirect()->route('coordinadores.index')
                ->with('success', "Coordinador {$request->nombre} creado. Email: {$request->email}");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear coordinador', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Error al crear: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Coordinador $coordinador)
    {
        $coordinador->load(['user', 'puesto']);

        $municipios = Puesto::select('municipio_codigo', 'municipio_nombre')
            ->distinct()->orderBy('municipio_nombre')->get();

        $puestosPorMunicipioZona = [];
        foreach ($municipios as $municipio) {
            $munCodigo = $municipio->municipio_codigo;
            $puestosPorMunicipioZona[$munCodigo] = [
                'nombre' => $municipio->municipio_nombre,
                'zonas'  => [],
            ];
            $zonas = Puesto::where('municipio_codigo', $munCodigo)
                ->select('zona')->distinct()->orderBy('zona')->get();

            foreach ($zonas as $zona) {
                $puestos = Puesto::where('municipio_codigo', $munCodigo)
                    ->where('zona', $zona->zona)
                    ->withCount('mesas')
                    ->orderBy('puesto')
                    ->get()
                    ->map(fn($p) => [
                        'id'          => $p->id,
                        'puesto'      => $p->puesto,
                        'nombre'      => $p->nombre ?? 'Sin nombre',
                        'direccion'   => $p->direccion ?? '',
                        'total_mesas' => $p->total_mesas ?? 0,
                    ])->toArray();

                $puestosPorMunicipioZona[$munCodigo]['zonas'][$zona->zona] = $puestos;
            }
        }

        $puestoActual    = $coordinador->puesto;
        $municipioActual = $puestoActual ? $puestoActual->municipio_codigo : null;
        $zonaActual      = $puestoActual ? $puestoActual->zona : null;

        return view('coordinadores.edit', compact(
            'coordinador', 'municipios', 'puestosPorMunicipioZona', 'municipioActual', 'zonaActual'
        ));
    }

    public function update(Request $request, Coordinador $coordinador)
    {
        $emailRule = 'required|email|unique:users,email';
        if ($coordinador->user_id) {
            $emailRule = 'required|email|unique:users,email,' . $coordinador->user_id;
        }

        $request->validate([
            'fk_id_zona'   => 'required|string|max:10',
            'fk_id_puesto' => 'required|exists:puesto,id',
            'documento'    => 'required|string|max:20|unique:coordinadores,documento,' . $coordinador->id,
            'nombre'       => 'required|string|max:60',
            'email'        => $emailRule,
            'password'     => ($coordinador->user_id ? 'nullable' : 'required') . '|string|min:6',
        ]);

        try {
            DB::beginTransaction();

            if ($coordinador->user_id) {
                $user = User::find($coordinador->user_id);
                $user->name  = $request->nombre;
                $user->email = $request->email;
                if ($request->filled('password')) {
                    $user->password       = Hash::make($request->password);
                    $user->password_texto = $request->password;
                }
                $user->save();
            } elseif ($request->filled('email') && $request->filled('password')) {
                // Crear usuario nuevo si no tenía uno vinculado
                $user = User::create([
                    'name'              => $request->nombre,
                    'email'             => $request->email,
                    'password'          => Hash::make($request->password),
                    'password_texto'    => $request->password,
                    'role'              => 'coordinador',
                    'email_verified_at' => now(),
                ]);
                $coordinador->user_id = $user->id;
            }

            $coordinador->update([
                'fk_id_zona'   => $request->fk_id_zona,
                'fk_id_puesto' => $request->fk_id_puesto,
                'documento'    => $request->documento,
                'nombre'       => $request->nombre,
            ]);

            DB::commit();

            return redirect()->route('coordinadores.index')
                ->with('success', 'Coordinador actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Coordinador $coordinador)
    {
        try {
            DB::beginTransaction();
            if ($coordinador->user_id) {
                User::find($coordinador->user_id)?->delete();
            }
            $coordinador->delete();
            DB::commit();
            return redirect()->route('coordinadores.index')
                ->with('success', 'Coordinador eliminado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}
