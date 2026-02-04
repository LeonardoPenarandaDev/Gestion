<?php

namespace App\Http\Controllers;

use App\Models\Testigo;
use App\Models\Puesto;
use App\Models\Mesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class TestigoController extends Controller
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
     * Mostrar lista de testigos
     */
    public function index()
    {
        $testigos = Testigo::with(['puesto', 'mesas', 'user'])
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
        // Obtener municipios únicos
        $municipios = Puesto::select('municipio_codigo', 'municipio_nombre')
            ->distinct()
            ->orderBy('municipio_nombre')
            ->get();

        // Estructura jerárquica: municipio -> zona -> puestos
        $puestosPorMunicipioZona = [];

        foreach ($municipios as $municipio) {
            $munCodigo = $municipio->municipio_codigo;
            $puestosPorMunicipioZona[$munCodigo] = [
                'nombre' => $municipio->municipio_nombre,
                'zonas' => []
            ];

            // Obtener zonas de este municipio
            $zonas = Puesto::where('municipio_codigo', $munCodigo)
                ->select('zona')
                ->distinct()
                ->orderBy('zona')
                ->get();

            foreach ($zonas as $zona) {
                $zonaNum = $zona->zona;

                $puestos = Puesto::where('municipio_codigo', $munCodigo)
                    ->where('zona', $zonaNum)
                    ->with(['mesas:puesto_id,numero_mesa'])
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
                            'mesas_ocupadas_ids' => $puesto->mesas->pluck('numero_mesa')->toArray(),
                        ];
                    })
                    ->toArray();

                $puestosPorMunicipioZona[$munCodigo]['zonas'][$zonaNum] = $puestos;
            }
        }

        return view('testigos.create', [
            'municipios' => $municipios,
            'puestosPorMunicipioZona' => $puestosPorMunicipioZona,
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
            'alias' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:6|required_with:email',
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
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.required_with' => 'La contraseña es obligatoria si proporciona un email',
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

            // Crear el usuario si se proporciona email y contraseña
            $userId = null;
            if ($request->filled('email') && $request->filled('password')) {
                $user = User::create([
                    'name' => $request->nombre,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'testigo',
                    'email_verified_at' => now(),
                ]);
                $userId = $user->id;
                Log::info('Usuario testigo creado', ['user_id' => $user->id, 'email' => $request->email]);
            }

            // Crear el testigo
            $testigo = Testigo::create([
                'user_id' => $userId,
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

            $mensaje = 'Testigo creado exitosamente.';
            if ($userId) {
                $mensaje .= ' Se ha creado acceso al portal con el email: ' . $request->email;
            }

            return redirect()->route('testigos.index')
                            ->with('success', $mensaje);
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
        $testigo->load(['puesto', 'mesas', 'user']);
        return view('testigos.show', compact('testigo'));
    }

    /**
     * Mostrar formulario para editar testigo
     */
    public function edit(Testigo $testigo)
    {
        // Obtener municipios únicos
        $municipios = Puesto::select('municipio_codigo', 'municipio_nombre')
            ->distinct()
            ->orderBy('municipio_nombre')
            ->get();

        // Estructura jerárquica: municipio -> zona -> puestos
        $puestosPorMunicipioZona = [];

        foreach ($municipios as $municipio) {
            $munCodigo = $municipio->municipio_codigo;
            $puestosPorMunicipioZona[$munCodigo] = [
                'nombre' => $municipio->municipio_nombre,
                'zonas' => []
            ];

            $zonas = Puesto::where('municipio_codigo', $munCodigo)
                ->select('zona')
                ->distinct()
                ->orderBy('zona')
                ->get();

            foreach ($zonas as $zona) {
                $zonaNum = $zona->zona;

                $puestos = Puesto::where('municipio_codigo', $munCodigo)
                    ->where('zona', $zonaNum)
                    ->with(['mesas:puesto_id,numero_mesa,testigo_id'])
                    ->withCount('mesas')
                    ->orderBy('puesto')
                    ->get()
                    ->map(function($puesto) use ($testigo) {
                        $mesasOcupadasPorOtros = $puesto->mesas
                            ->where('testigo_id', '!=', $testigo->id)
                            ->pluck('numero_mesa')
                            ->toArray();

                        return [
                            'id' => $puesto->id,
                            'puesto' => $puesto->puesto,
                            'nombre' => $puesto->nombre ?? 'Sin nombre',
                            'direccion' => $puesto->direccion ?? 'Sin dirección',
                            'total_mesas' => $puesto->total_mesas ?? 0,
                            'mesas_ocupadas' => $puesto->mesas_count ?? 0,
                            'mesas_ocupadas_ids' => $mesasOcupadasPorOtros,
                        ];
                    })
                    ->toArray();

                $puestosPorMunicipioZona[$munCodigo]['zonas'][$zonaNum] = $puestos;
            }
        }

        // Cargar las mesas y usuario del testigo actual
        $testigo->load(['mesas', 'user']);

        // Obtener datos actuales del puesto del testigo
        $puestoActual = Puesto::find($testigo->fk_id_puesto);
        $municipioActual = $puestoActual ? $puestoActual->municipio_codigo : null;
        $zonaActual = $puestoActual ? $puestoActual->zona : null;

        return view('testigos.edit', [
            'testigo' => $testigo,
            'municipios' => $municipios,
            'puestosPorMunicipioZona' => $puestosPorMunicipioZona,
            'municipioActual' => $municipioActual,
            'zonaActual' => $zonaActual,
        ]);
    }

    /**
     * Actualizar testigo
     */
    public function update(Request $request, Testigo $testigo)
    {
        // Determinar la regla de validación de email según si existe usuario
        $emailRule = 'nullable|email|unique:users,email';
        if ($testigo->user_id) {
            $emailRule = 'nullable|email|unique:users,email,' . $testigo->user_id;
        }

        $validator = Validator::make($request->all(), [
            'fk_id_zona' => 'required|string|max:10',
            'fk_id_puesto' => 'required|exists:puesto,id',
            'documento' => 'required|string|max:20|unique:testigo,documento,' . $testigo->id,
            'nombre' => 'required|string|max:30',
            'mesas' => 'required|array|min:1',
            'mesas.*' => 'required|integer|min:1',
            'alias' => 'nullable|string|max:20',
            'email' => $emailRule,
            'password' => 'nullable|min:6',
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
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ]);

        // Validación adicional: si no tiene usuario y proporciona email, requiere contraseña
        $validator->after(function ($validator) use ($request, $testigo) {
            if (!$testigo->user_id && $request->filled('email') && !$request->filled('password')) {
                $validator->errors()->add('password', 'La contraseña es obligatoria para crear un nuevo usuario.');
            }
        });

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

            // Manejar usuario (crear o actualizar)
            $mensaje = 'Testigo actualizado exitosamente.';
            if ($request->filled('email')) {
                if ($testigo->user_id) {
                    // Actualizar usuario existente
                    $user = User::find($testigo->user_id);
                    $user->name = $request->nombre;
                    $user->email = $request->email;
                    if ($request->filled('password')) {
                        $user->password = Hash::make($request->password);
                        $mensaje .= ' Contraseña actualizada.';
                    }
                    $user->save();
                    $mensaje .= ' Acceso al portal actualizado.';
                } else {
                    // Crear nuevo usuario
                    $user = User::create([
                        'name' => $request->nombre,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'role' => 'testigo',
                        'email_verified_at' => now(),
                    ]);
                    $testigo->user_id = $user->id;
                    $mensaje .= ' Acceso al portal creado con el email: ' . $request->email;
                }
            }

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
                            ->with('success', $mensaje);
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

    /**
     * Mostrar formulario de importacion CSV
     */
    public function importForm()
    {
        return view('testigos.import');
    }

    /**
     * Descargar plantilla CSV de ejemplo
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="plantilla_testigos.csv"',
        ];

        $columns = ['documento', 'nombre', 'zona', 'puesto', 'mesas', 'alias', 'email', 'password'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            // Header
            fputcsv($file, $columns, ';');
            // Ejemplos con zona 01 puesto 01
            fputcsv($file, ['12345678', 'Juan Perez', '01', '01', '1,2,3', 'juanp', 'juan@email.com', '123456'], ';');
            fputcsv($file, ['87654321', 'Maria Lopez', '01', '02', '4,5', '', '', ''], ';');
            fputcsv($file, ['11223344', 'Carlos Garcia', '02', '01', '1', '', '', ''], ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Procesar importacion de CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'archivo_csv' => 'required|file|max:2048',
            'password_predeterminada' => 'nullable|string|min:6',
        ], [
            'archivo_csv.required' => 'Debe seleccionar un archivo CSV',
            'archivo_csv.max' => 'El archivo no puede exceder 2MB',
            'password_predeterminada.min' => 'La contraseña predeterminada debe tener al menos 6 caracteres',
        ]);

        $archivo = $request->file('archivo_csv');

        $resultados = [
            'exitosos' => 0,
            'errores' => [],
            'advertencias' => [],
        ];

        try {
            $contenido = file_get_contents($archivo->getRealPath());
            // Remover BOM si existe
            $contenido = preg_replace('/^\xEF\xBB\xBF/', '', $contenido);

            // Normalizar saltos de linea
            $contenido = str_replace(["\r\n", "\r"], "\n", $contenido);
            $lineas = explode("\n", $contenido);
            $lineas = array_values(array_filter($lineas, fn($linea) => trim($linea) !== ''));

            Log::info('Importacion CSV iniciada', [
                'archivo' => $archivo->getClientOriginalName(),
                'total_lineas' => count($lineas),
            ]);

            if (count($lineas) < 2) {
                return redirect()->back()->withErrors(['archivo_csv' => 'El archivo esta vacio o solo tiene encabezados. Lineas encontradas: ' . count($lineas)]);
            }

            // Detectar separador (punto y coma, coma o tabulador)
            $primeraLinea = $lineas[0];
            $separador = ';';
            if (substr_count($primeraLinea, ',') > substr_count($primeraLinea, ';')) {
                $separador = ',';
            } elseif (substr_count($primeraLinea, "\t") > substr_count($primeraLinea, ';')) {
                $separador = "\t";
            }

            Log::info('Separador detectado', ['separador' => $separador === "\t" ? 'TAB' : $separador]);

            // Obtener encabezados
            $encabezados = str_getcsv($lineas[0], $separador);
            $encabezados = array_map('trim', $encabezados);
            $encabezados = array_map('strtolower', $encabezados);

            Log::info('Encabezados encontrados', ['encabezados' => $encabezados]);

            // Validar columnas requeridas (puesto en lugar de puesto_id)
            $columnasRequeridas = ['documento', 'nombre', 'zona', 'puesto', 'mesas'];
            $columnasFaltantes = array_diff($columnasRequeridas, $encabezados);

            if (!empty($columnasFaltantes)) {
                return redirect()->back()->withErrors([
                    'archivo_csv' => 'Faltan columnas requeridas: ' . implode(', ', $columnasFaltantes) . '. Columnas encontradas: ' . implode(', ', $encabezados)
                ]);
            }

            DB::beginTransaction();

            // Iterar desde la linea 1 (saltando el encabezado en linea 0)
            $totalLineas = count($lineas);
            for ($i = 1; $i < $totalLineas; $i++) {
                $linea = $lineas[$i];
                $fila = $i + 1; // +1 para mostrar numero de fila real en el archivo

                try {
                    $datos = str_getcsv($linea, $separador);

                    // Verificar que tenemos suficientes columnas
                    if (count($datos) < count($encabezados)) {
                        $datos = array_pad($datos, count($encabezados), '');
                    }

                    $registro = array_combine($encabezados, array_slice($datos, 0, count($encabezados)));

                    // Limpiar datos
                    $registro = array_map('trim', $registro);

                    // Validar datos requeridos
                    if (empty($registro['documento']) || empty($registro['nombre']) ||
                        empty($registro['zona']) || empty($registro['puesto']) || empty($registro['mesas'])) {
                        $resultados['errores'][] = "Fila {$fila}: Campos obligatorios vacios";
                        continue;
                    }

                    // Verificar si el documento ya existe
                    if (Testigo::where('documento', $registro['documento'])->exists()) {
                        $resultados['advertencias'][] = "Fila {$fila}: Documento {$registro['documento']} ya existe, omitido";
                        continue;
                    }

                    // Normalizar zona y puesto (agregar cero inicial si es necesario)
                    $zonaNum = str_pad($registro['zona'], 2, '0', STR_PAD_LEFT);
                    $puestoNum = str_pad($registro['puesto'], 2, '0', STR_PAD_LEFT);

                    // Buscar puesto por zona + numero de puesto
                    $puesto = Puesto::where('zona', $zonaNum)
                        ->where('puesto', $puestoNum)
                        ->first();

                    if (!$puesto) {
                        $resultados['errores'][] = "Fila {$fila}: No existe puesto {$puestoNum} en zona {$zonaNum}";
                        continue;
                    }

                    // Parsear mesas (separadas por coma)
                    $mesas = array_map('trim', explode(',', $registro['mesas']));
                    $mesas = array_filter($mesas, fn($m) => is_numeric($m) && $m > 0);

                    if (empty($mesas)) {
                        $resultados['errores'][] = "Fila {$fila}: No hay mesas validas";
                        continue;
                    }

                    // Verificar rango de mesas
                    foreach ($mesas as $numMesa) {
                        if ($numMesa > $puesto->total_mesas) {
                            $resultados['errores'][] = "Fila {$fila}: Mesa {$numMesa} excede el total del puesto ({$puesto->total_mesas})";
                            continue 2;
                        }
                        // Verificar si la mesa ya esta asignada
                        if (Mesa::where('puesto_id', $puesto->id)->where('numero_mesa', $numMesa)->exists()) {
                            $resultados['advertencias'][] = "Fila {$fila}: Mesa {$numMesa} ya asignada en puesto {$puesto->id}";
                        }
                    }

                    // Crear usuario automáticamente
                    $userId = null;
                    $email = !empty($registro['email'])
                        ? $registro['email']
                        : strtolower(preg_replace('/[^a-zA-Z0-9]/', '.', $registro['nombre'])) . '.' . $registro['documento'] . '@testigo.com';
                    
                    // Determinar contraseña: prioridad a password_predeterminada, luego CSV, luego auto-generar
                    if ($request->filled('password_predeterminada')) {
                        $password = $request->password_predeterminada;
                    } elseif (!empty($registro['password'])) {
                        $password = $registro['password'];
                    } else {
                        $password = 'testigo' . $registro['documento'];
                    }

                    if (User::where('email', $email)->exists()) {
                        // Si el email ya existe, vincular al usuario existente
                        $userExistente = User::where('email', $email)->first();
                        $userId = $userExistente->id;
                        $resultados['advertencias'][] = "Fila {$fila}: Usuario {$email} ya existía, testigo vinculado";
                    } else {
                        $user = User::create([
                            'name' => $registro['nombre'],
                            'email' => $email,
                            'password' => Hash::make($password),
                            'role' => 'testigo',
                            'email_verified_at' => now(),
                        ]);
                        $userId = $user->id;
                    }

                    // Crear testigo
                    $testigo = Testigo::create([
                        'user_id' => $userId,
                        'fk_id_zona' => $zonaNum,
                        'fk_id_puesto' => $puesto->id,
                        'documento' => $registro['documento'],
                        'nombre' => $registro['nombre'],
                        'alias' => $registro['alias'] ?? null,
                    ]);

                    // Crear mesas
                    foreach ($mesas as $numMesa) {
                        // Evitar duplicados
                        if (!Mesa::where('puesto_id', $puesto->id)->where('numero_mesa', $numMesa)->exists()) {
                            Mesa::create([
                                'testigo_id' => $testigo->id,
                                'puesto_id' => $puesto->id,
                                'numero_mesa' => $numMesa,
                            ]);
                        }
                    }

                    $resultados['exitosos']++;

                } catch (\Exception $e) {
                    $resultados['errores'][] = "Fila {$fila}: " . $e->getMessage();
                }
            }

            DB::commit();

            Log::info('Importacion CSV completada', [
                'exitosos' => $resultados['exitosos'],
                'errores' => count($resultados['errores']),
                'advertencias' => count($resultados['advertencias']),
            ]);

            $mensaje = "Importacion completada: {$resultados['exitosos']} testigos creados.";
            if (!empty($resultados['errores'])) {
                $mensaje .= " " . count($resultados['errores']) . " errores.";
            }
            if (!empty($resultados['advertencias'])) {
                $mensaje .= " " . count($resultados['advertencias']) . " advertencias.";
            }

            // Si no hubo exitos pero tampoco errores explicitos, dar mas contexto
            if ($resultados['exitosos'] === 0 && empty($resultados['errores'])) {
                $mensaje = "No se importaron testigos. Verifique que el archivo tenga datos despues del encabezado.";
            }

            return redirect()->route('testigos.index')
                ->with('success', $mensaje)
                ->with('import_errores', $resultados['errores'])
                ->with('import_advertencias', $resultados['advertencias']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en importacion CSV', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['archivo_csv' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }
}