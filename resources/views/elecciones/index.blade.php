<x-app-layout>
    <x-slot name="header">
        <div style="background:linear-gradient(135deg,#1e3a5f 0%,#1d4ed8 100%);border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,0.15);">
            <div style="padding:1.75rem 2rem;">
                <h2 style="color:white;font-size:1.75rem;font-weight:800;margin:0;">Gestión de Elecciones</h2>
                <p style="color:rgba(255,255,255,0.75);margin:0.3rem 0 0;font-size:0.875rem;">
                    Crea elecciones, agrega candidatos y actívalas o desactívalas según el calendario electoral
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        body { font-family:'Inter',sans-serif !important; background:#f1f5f9 !important; }

        .page-grid { display:grid; grid-template-columns:360px 1fr; gap:1.5rem; align-items:start; }
        @media(max-width:900px){ .page-grid{ grid-template-columns:1fr; } }

        /* ── Card genérico ── */
        .card { background:white; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; }
        .card-head { padding:1rem 1.25rem; border-bottom:1px solid #f3f4f6; font-weight:700; font-size:0.95rem; color:#111827; }
        .card-body { padding:1.25rem; }

        /* ── Form inputs ── */
        .f-label { display:block; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:#6b7280; margin-bottom:.35rem; }
        .f-input {
            width:100%; padding:.55rem .85rem; border:2px solid #e5e7eb; border-radius:8px;
            font-size:.875rem; color:#1f2937; background:white; transition:border-color .2s;
        }
        .f-input:focus { outline:none; border-color:#2563eb; }
        .f-group { margin-bottom:.9rem; }

        /* ── Botones ── */
        .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:8px; border:none; font-size:.82rem; font-weight:700; cursor:pointer; text-decoration:none; transition:all .2s; }
        .btn-primary   { background:linear-gradient(135deg,#2563eb,#1d4ed8); color:white; }
        .btn-success   { background:linear-gradient(135deg,#16a34a,#15803d); color:white; }
        .btn-danger    { background:#fee2e2; color:#991b1b; }
        .btn-warn      { background:#fef3c7; color:#92400e; }
        .btn-gray      { background:#f3f4f6; color:#374151; }
        .btn-sm        { padding:.3rem .7rem; font-size:.75rem; }
        .btn:hover     { opacity:.88; transform:translateY(-1px); }

        /* ── Elección card ── */
        .eleccion-card { background:white; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; margin-bottom:1rem; }
        .eleccion-head {
            padding:.85rem 1.25rem; display:flex; align-items:center; justify-content:space-between; gap:.75rem; flex-wrap:wrap;
            color:white; font-weight:800;
        }
        .eleccion-head .badge-activa   { background:rgba(255,255,255,.25); padding:.2rem .65rem; border-radius:20px; font-size:.7rem; font-weight:700; }
        .eleccion-head .badge-inactiva { background:rgba(0,0,0,.25); padding:.2rem .65rem; border-radius:20px; font-size:.7rem; font-weight:700; }

        .eleccion-body { padding:1rem 1.25rem; }

        /* ── Lista de candidatos ── */
        .candidatos-list { margin:0; padding:0; list-style:none; }
        .candidato-row {
            display:flex; align-items:center; gap:.5rem; padding:.4rem .5rem;
            border-radius:8px; transition:background .15s;
        }
        .candidato-row:hover { background:#f9fafb; }
        .candidato-nombre { flex:1; font-size:.85rem; font-weight:600; color:#1f2937; }
        .candidato-nombre.inactivo { color:#9ca3af; text-decoration:line-through; font-weight:400; }
        .chip-propio { font-size:.65rem; font-weight:700; padding:.15rem .5rem; border-radius:20px; background:#dcfce7; color:#166534; white-space:nowrap; }
        .chip-comp   { font-size:.65rem; font-weight:700; padding:.15rem .5rem; border-radius:20px; background:#fef2f2; color:#991b1b; white-space:nowrap; }
        .chip-off    { font-size:.65rem; font-weight:700; padding:.15rem .5rem; border-radius:20px; background:#f3f4f6; color:#6b7280; white-space:nowrap; }

        /* ── Collapsible edit ── */
        .edit-panel { display:none; background:#f9fafb; border-radius:8px; padding:.75rem; margin:.5rem 0; border:1px solid #e5e7eb; }
        .edit-panel.open { display:block; }

        /* ── Add candidato form inline ── */
        .add-candidato-form { display:grid; grid-template-columns:1fr auto auto auto; gap:.5rem; align-items:end; margin-top:.75rem; }
        @media(max-width:600px){ .add-candidato-form{ grid-template-columns:1fr 1fr; } }

        /* ── Separador tipo ── */
        .tipo-sep { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#9ca3af; padding:.5rem 0 .2rem; border-top:1px solid #f3f4f6; margin-top:.5rem; }
    </style>

    <div style="padding:1.75rem 0 3rem;">
        <div style="max-width:1200px;margin:0 auto;padding:0 1rem;">

            @if(session('success'))
                <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:.875rem 1.25rem;margin-bottom:1rem;color:#166534;font-weight:600;">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:10px;padding:.875rem 1.25rem;margin-bottom:1rem;color:#991b1b;font-weight:600;">
                    ✗ {{ session('error') }}
                </div>
            @endif

            <div class="page-grid">

                {{-- ── COLUMNA IZQUIERDA: crear nueva elección ── --}}
                <div>
                    <div class="card">
                        <div class="card-head">➕ Nueva Elección</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('elecciones.store') }}">
                                @csrf
                                <div class="f-group">
                                    <label class="f-label">Nombre *</label>
                                    <input class="f-input" type="text" name="nombre" required placeholder="Ej: Cámara - Congreso 2026" value="{{ old('nombre') }}">
                                </div>
                                <div class="f-group">
                                    <label class="f-label">Tipo / Cargo *</label>
                                    <input class="f-input" type="text" name="tipo_cargo" required
                                           placeholder="senado · camara · presidencia · concejo · alcaldia"
                                           list="cargos-list" value="{{ old('tipo_cargo') }}">
                                    <datalist id="cargos-list">
                                        <option value="senado">
                                        <option value="camara">
                                        <option value="presidencia">
                                        <option value="concejo">
                                        <option value="alcaldia">
                                    </datalist>
                                </div>
                                <div class="f-group">
                                    <label class="f-label">Fecha de la elección</label>
                                    <input class="f-input" type="date" name="fecha" value="{{ old('fecha') }}">
                                </div>
                                <div class="f-group">
                                    <label class="f-label">Descripción (opcional)</label>
                                    <textarea class="f-input" name="descripcion" rows="2" placeholder="Nota o contexto...">{{ old('descripcion') }}</textarea>
                                </div>
                                <div class="f-group">
                                    <label class="f-label">Color identificador</label>
                                    <div style="display:flex;gap:.5rem;align-items:center;">
                                        <input type="color" name="color" value="{{ old('color','#2563eb') }}"
                                               style="width:42px;height:36px;border:2px solid #e5e7eb;border-radius:6px;padding:2px;cursor:pointer;">
                                        <span style="font-size:.78rem;color:#6b7280;">Se muestra en el encabezado de la elección</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.7rem;">
                                    Crear Elección
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- ── Tipos de cargo disponibles ── --}}
                    <div class="card" style="margin-top:1rem;">
                        <div class="card-head" style="font-size:.85rem;">📋 Tipos de cargo comunes</div>
                        <div class="card-body" style="padding:.75rem 1.25rem;">
                            <div style="display:flex;flex-wrap:wrap;gap:.4rem;">
                                @foreach(['senado','camara','presidencia','concejo','alcaldia','gobernacion','asamblea'] as $tipo)
                                    <span style="padding:.2rem .7rem;border-radius:20px;background:#f3f4f6;font-size:.75rem;font-weight:600;color:#374151;">{{ $tipo }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── COLUMNA DERECHA: lista de elecciones ── --}}
                <div>
                    @if($elecciones->isEmpty())
                        <div style="background:white;border-radius:14px;padding:3rem;text-align:center;color:#9ca3af;box-shadow:0 2px 10px rgba(0,0,0,0.07);">
                            No hay elecciones registradas. Crea una a la izquierda.
                        </div>
                    @else
                    @foreach($elecciones as $eleccion)
                    @php
                        $propios = $eleccion->candidatos->where('tipo','propio');
                        $comp    = $eleccion->candidatos->where('tipo','competencia');
                    @endphp
                    <div class="eleccion-card">
                        {{-- Encabezado de la elección --}}
                        <div class="eleccion-head" style="background:{{ $eleccion->color }};">
                            <div>
                                <div style="font-size:1.05rem;">{{ $eleccion->nombre }}</div>
                                <div style="font-size:.75rem;opacity:.85;font-weight:500;margin-top:.15rem;">
                                    {{ ucfirst($eleccion->tipo_cargo) }}
                                    @if($eleccion->fecha) · {{ $eleccion->fecha->format('d/m/Y') }} @endif
                                    · {{ $eleccion->candidatos->count() }} candidato{{ $eleccion->candidatos->count() !== 1 ? 's' : '' }}
                                </div>
                            </div>
                            <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap;">
                                <span class="{{ $eleccion->activa ? 'badge-activa' : 'badge-inactiva' }}">
                                    {{ $eleccion->activa ? '● Activa' : '○ Inactiva' }}
                                </span>
                                <button class="btn btn-sm" style="background:rgba(255,255,255,.2);color:white;"
                                        onclick="toggleEdit('edit-elec-{{ $eleccion->id }}')">
                                    ✏ Editar
                                </button>
                            </div>
                        </div>

                        {{-- Panel editar elección (oculto) --}}
                        <div class="edit-panel" id="edit-elec-{{ $eleccion->id }}" style="margin:.75rem 1rem 0;">
                            <form method="POST" action="{{ route('elecciones.update', $eleccion) }}" style="display:grid;grid-template-columns:1fr 1fr auto auto;gap:.5rem;align-items:end;flex-wrap:wrap;">
                                @csrf @method('PUT')
                                <div>
                                    <label class="f-label">Nombre</label>
                                    <input class="f-input" type="text" name="nombre" required value="{{ $eleccion->nombre }}">
                                </div>
                                <div>
                                    <label class="f-label">Tipo / Cargo</label>
                                    <input class="f-input" type="text" name="tipo_cargo" required value="{{ $eleccion->tipo_cargo }}" list="cargos-list">
                                </div>
                                <div>
                                    <label class="f-label">Fecha</label>
                                    <input class="f-input" type="date" name="fecha" value="{{ $eleccion->fecha?->format('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="f-label">Color</label>
                                    <input type="color" name="color" value="{{ $eleccion->color }}"
                                           style="width:42px;height:36px;border:2px solid #e5e7eb;border-radius:6px;padding:2px;cursor:pointer;">
                                </div>
                                <div style="grid-column:1/-1;">
                                    <label class="f-label">Descripción</label>
                                    <input class="f-input" type="text" name="descripcion" value="{{ $eleccion->descripcion }}" placeholder="Opcional">
                                </div>
                                <div style="grid-column:1/-1;display:flex;gap:.5rem;">
                                    <button type="submit" class="btn btn-primary btn-sm">💾 Guardar</button>
                                    <button type="button" class="btn btn-gray btn-sm" onclick="toggleEdit('edit-elec-{{ $eleccion->id }}')">Cancelar</button>
                                </div>
                            </form>
                            <div style="border-top:1px solid #e5e7eb;margin-top:.75rem;padding-top:.75rem;display:flex;gap:.5rem;">
                                {{-- Toggle activa --}}
                                <form method="POST" action="{{ route('elecciones.toggle', $eleccion) }}" style="margin:0;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $eleccion->activa ? 'btn-warn' : 'btn-success' }}">
                                        {{ $eleccion->activa ? '⏸ Desactivar' : '▶ Activar' }}
                                    </button>
                                </form>
                                {{-- Eliminar (solo si no tiene candidatos) --}}
                                <form method="POST" action="{{ route('elecciones.destroy', $eleccion) }}" style="margin:0;"
                                      onsubmit="return confirm('¿Eliminar la elección {{ addslashes($eleccion->nombre) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑 Eliminar</button>
                                </form>
                            </div>
                        </div>

                        <div class="eleccion-body">
                            {{-- Lista de candidatos --}}
                            @if($eleccion->candidatos->count() > 0)
                            <ul class="candidatos-list">
                                {{-- Propios --}}
                                @if($propios->count())
                                <li><div class="tipo-sep">Nuestros candidatos</div></li>
                                @foreach($propios->sortBy('orden') as $cand)
                                <li>
                                    <div class="candidato-row">
                                        <span style="font-size:.7rem;color:#9ca3af;min-width:20px;text-align:right;">{{ $cand->orden }}</span>
                                        <span class="candidato-nombre {{ $cand->activo ? '' : 'inactivo' }}">{{ $cand->nombre }}</span>
                                        <span class="{{ $cand->activo ? 'chip-propio' : 'chip-off' }}">
                                            {{ $cand->activo ? 'Propio' : 'Inactivo' }}
                                        </span>
                                        <button class="btn btn-gray btn-sm" onclick="toggleEdit('edit-cand-{{ $cand->id }}')">✏</button>
                                        <form method="POST" action="{{ route('elecciones.candidatos.toggle', [$eleccion, $cand]) }}" style="margin:0;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $cand->activo ? 'btn-warn' : 'btn-success' }}" title="{{ $cand->activo ? 'Desactivar' : 'Activar' }}">
                                                {{ $cand->activo ? '⏸' : '▶' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('elecciones.candidatos.destroy', [$eleccion, $cand]) }}" style="margin:0;"
                                              onsubmit="return confirm('¿Eliminar a {{ addslashes($cand->nombre) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">🗑</button>
                                        </form>
                                    </div>
                                    <div class="edit-panel" id="edit-cand-{{ $cand->id }}" style="margin-left:1.5rem;">
                                        <form method="POST" action="{{ route('elecciones.candidatos.update', [$eleccion, $cand]) }}"
                                              style="display:grid;grid-template-columns:1fr auto auto auto;gap:.5rem;align-items:end;">
                                            @csrf @method('PATCH')
                                            <input class="f-input" type="text" name="nombre" value="{{ $cand->nombre }}" required>
                                            <select class="f-input" name="tipo">
                                                <option value="propio"      {{ $cand->tipo==='propio'      ? 'selected':'' }}>Propio</option>
                                                <option value="competencia" {{ $cand->tipo==='competencia' ? 'selected':'' }}>Competencia</option>
                                            </select>
                                            <input class="f-input" type="number" name="orden" value="{{ $cand->orden }}" style="width:60px;" placeholder="Orden">
                                            <div style="display:flex;gap:.4rem;">
                                                <button type="submit" class="btn btn-primary btn-sm">✓</button>
                                                <button type="button" class="btn btn-gray btn-sm" onclick="toggleEdit('edit-cand-{{ $cand->id }}')">✕</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                @endforeach
                                @endif

                                {{-- Competencia --}}
                                @if($comp->count())
                                <li><div class="tipo-sep">Competencia ({{ $comp->count() }} candidatos · {{ $comp->where('activo',true)->count() }} activos)</div></li>
                                @foreach($comp->sortBy('orden') as $cand)
                                <li>
                                    <div class="candidato-row">
                                        <span style="font-size:.7rem;color:#9ca3af;min-width:20px;text-align:right;">{{ $cand->orden }}</span>
                                        <span class="candidato-nombre {{ $cand->activo ? '' : 'inactivo' }}">{{ $cand->nombre }}</span>
                                        <span class="{{ $cand->activo ? 'chip-comp' : 'chip-off' }}">
                                            {{ $cand->activo ? 'Comp.' : 'Inactivo' }}
                                        </span>
                                        <button class="btn btn-gray btn-sm" onclick="toggleEdit('edit-cand-{{ $cand->id }}')">✏</button>
                                        <form method="POST" action="{{ route('elecciones.candidatos.toggle', [$eleccion, $cand]) }}" style="margin:0;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $cand->activo ? 'btn-warn' : 'btn-success' }}" title="{{ $cand->activo ? 'Desactivar' : 'Activar' }}">
                                                {{ $cand->activo ? '⏸' : '▶' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('elecciones.candidatos.destroy', [$eleccion, $cand]) }}" style="margin:0;"
                                              onsubmit="return confirm('¿Eliminar a {{ addslashes($cand->nombre) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">🗑</button>
                                        </form>
                                    </div>
                                    <div class="edit-panel" id="edit-cand-{{ $cand->id }}" style="margin-left:1.5rem;">
                                        <form method="POST" action="{{ route('elecciones.candidatos.update', [$eleccion, $cand]) }}"
                                              style="display:grid;grid-template-columns:1fr auto auto auto;gap:.5rem;align-items:end;">
                                            @csrf @method('PATCH')
                                            <input class="f-input" type="text" name="nombre" value="{{ $cand->nombre }}" required>
                                            <select class="f-input" name="tipo">
                                                <option value="propio"      {{ $cand->tipo==='propio'      ? 'selected':'' }}>Propio</option>
                                                <option value="competencia" {{ $cand->tipo==='competencia' ? 'selected':'' }}>Competencia</option>
                                            </select>
                                            <input class="f-input" type="number" name="orden" value="{{ $cand->orden }}" style="width:60px;" placeholder="Orden">
                                            <div style="display:flex;gap:.4rem;">
                                                <button type="submit" class="btn btn-primary btn-sm">✓</button>
                                                <button type="button" class="btn btn-gray btn-sm" onclick="toggleEdit('edit-cand-{{ $cand->id }}')">✕</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                            @else
                                <p style="color:#9ca3af;font-size:.82rem;margin:0 0 .75rem;">Sin candidatos aún. Agrega el primero abajo.</p>
                            @endif

                            {{-- Formulario añadir candidato --}}
                            <div style="border-top:1px solid #f3f4f6;margin-top:.75rem;padding-top:.75rem;">
                                <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;color:#6b7280;margin-bottom:.5rem;">Agregar candidato</div>
                                <form method="POST" action="{{ route('elecciones.candidatos.store', $eleccion) }}"
                                      style="display:grid;grid-template-columns:1fr auto auto auto;gap:.5rem;align-items:end;">
                                    @csrf
                                    <input class="f-input" type="text" name="nombre" required placeholder="Nombre completo del candidato">
                                    <select class="f-input" name="tipo" style="min-width:120px;">
                                        <option value="competencia">Competencia</option>
                                        <option value="propio">Propio (nuestro)</option>
                                    </select>
                                    <input class="f-input" type="number" name="orden" placeholder="Orden" style="width:70px;" min="0">
                                    <button type="submit" class="btn btn-success">➕ Agregar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>{{-- end page-grid --}}
        </div>
    </div>

    <script>
        function toggleEdit(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.toggle('open');
        }
    </script>
</x-app-layout>
