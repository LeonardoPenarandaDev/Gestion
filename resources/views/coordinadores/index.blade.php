<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
            <h2 style="font-size:1.25rem;font-weight:700;color:#1f2937;margin:0;display:flex;align-items:center;gap:0.5rem;">
                <svg width="22" height="22" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Coordinadores
            </h2>
            <a href="{{ route('coordinadores.create') }}"
               style="background:linear-gradient(135deg,#667eea,#764ba2);color:white;padding:0.5rem 1.25rem;border-radius:10px;text-decoration:none;font-weight:600;font-size:0.875rem;display:inline-flex;align-items:center;gap:0.4rem;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Coordinador
            </a>
        </div>
    </x-slot>

    <style>
        body { font-family:'Inter',sans-serif !important; background:#f1f5f9 !important; }

        /* Buscador */
        .search-bar { background:white; border-radius:12px; padding:0.875rem 1.25rem; margin-bottom:1rem; box-shadow:0 2px 8px rgba(0,0,0,0.06); display:flex; align-items:center; gap:0.75rem; }
        .search-bar input { flex:1; border:none; outline:none; font-size:0.9rem; color:#1f2937; background:transparent; }

        /* Tabla */
        .table-wrap { background:white; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.07); overflow:hidden; }
        .table-scroll { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; table-layout:fixed; min-width:900px; }

        thead tr { background:#f8fafc; border-bottom:2px solid #e5e7eb; }
        th { padding:0.75rem 1rem; text-align:left; font-size:0.72rem; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.4px; white-space:nowrap; }

        tbody tr { border-bottom:1px solid #f3f4f6; transition:background 0.1s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:#fafafa; }
        td { padding:0.75rem 1rem; font-size:0.875rem; color:#374151; vertical-align:middle; }

        /* Truncado */
        .cell-truncate { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

        /* Avatar */
        .avatar { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#667eea,#764ba2); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:0.8rem; flex-shrink:0; }

        /* Badges */
        .badge-zona  { background:#dbeafe; color:#1e40af; padding:0.15rem 0.55rem; border-radius:8px; font-size:0.75rem; font-weight:700; white-space:nowrap; }
        .badge-mesas { background:#dcfce7; color:#166534; padding:0.15rem 0.55rem; border-radius:8px; font-size:0.75rem; font-weight:700; white-space:nowrap; }

        /* Acciones */
        .btn-edit { background:#f3f4f6; color:#374151; padding:0.3rem 0.7rem; border-radius:7px; text-decoration:none; font-size:0.78rem; font-weight:600; border:1px solid #e5e7eb; white-space:nowrap; }
        .btn-edit:hover { background:#e5e7eb; }
        .btn-del  { background:#fee2e2; color:#b91c1c; padding:0.3rem 0.7rem; border-radius:7px; font-size:0.78rem; font-weight:600; border:1px solid #fecaca; cursor:pointer; white-space:nowrap; }
        .btn-del:hover { background:#fecaca; }

        /* Anchos de columna */
        .col-nombre   { width:22%; }
        .col-doc      { width:12%; }
        .col-puesto   { width:22%; }
        .col-zona     { width:8%; }
        .col-email    { width:22%; }
        .col-mesas    { width:7%; }
        .col-acciones { width:7%; }
    </style>

    <div style="padding:1.5rem 0;">
        <div style="max-width:1400px; margin:0 auto; padding:0 1.25rem;">

            @if(session('success'))
            <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:0.75rem 1rem;margin-bottom:1rem;color:#166534;font-weight:600;font-size:0.875rem;">
                ✓ {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:10px;padding:0.75rem 1rem;margin-bottom:1rem;color:#991b1b;font-weight:600;font-size:0.875rem;">
                ✗ {{ session('error') }}
            </div>
            @endif

            {{-- Buscador --}}
            <div class="search-bar">
                <svg width="17" height="17" fill="none" stroke="#9ca3af" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
                <input type="text" id="buscador" placeholder="Buscar por nombre, documento, puesto, zona o email..."
                       oninput="filtrar()">
                <span id="conteo" style="font-size:0.78rem;color:#9ca3af;white-space:nowrap;flex-shrink:0;">
                    {{ $coordinadores->count() }} coordinadores
                </span>
            </div>

            {{-- Tabla --}}
            <div class="table-wrap">
                @if($coordinadores->isEmpty())
                <div style="text-align:center;padding:3rem;color:#9ca3af;">
                    No hay coordinadores registrados.
                </div>
                @else
                <div class="table-scroll">
                    <table>
                        <colgroup>
                            <col class="col-nombre">
                            <col class="col-doc">
                            <col class="col-puesto">
                            <col class="col-zona">
                            <col class="col-email">
                            <col class="col-mesas">
                            <col class="col-acciones">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Puesto</th>
                                <th>Zona</th>
                                <th>Email</th>
                                <th>Mesas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coordinadores as $c)
                            <tr class="coord-row"
                                data-nombre="{{ strtolower($c->nombre) }}"
                                data-documento="{{ $c->documento }}"
                                data-puesto="{{ strtolower($c->puesto?->nombre ?? '') }}"
                                data-zona="{{ $c->fk_id_zona }}"
                                data-email="{{ strtolower($c->user?->email ?? '') }}">

                                {{-- Nombre --}}
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.6rem;min-width:0;">
                                        <div class="avatar">{{ strtoupper(substr($c->nombre, 0, 1)) }}</div>
                                        <div style="min-width:0;">
                                            <div class="cell-truncate" style="font-weight:600;color:#1f2937;font-size:0.85rem;" title="{{ $c->nombre }}">
                                                {{ $c->nombre }}
                                            </div>
                                            <div style="font-size:0.7rem;color:#9ca3af;">{{ $c->documento }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Documento (oculto en pantallas pequeñas, se muestra en nombre) --}}
                                <td style="color:#6b7280;font-size:0.82rem;">{{ $c->documento }}</td>

                                {{-- Puesto --}}
                                <td>
                                    @if($c->puesto)
                                    <div class="cell-truncate" style="font-weight:600;color:#1f2937;font-size:0.82rem;" title="{{ $c->puesto->nombre }}">
                                        {{ $c->puesto->nombre }}
                                    </div>
                                    <div style="font-size:0.7rem;color:#9ca3af;">Puesto {{ $c->puesto->puesto }}</div>
                                    @else
                                    <span style="color:#9ca3af;font-size:0.82rem;">Sin puesto</span>
                                    @endif
                                </td>

                                {{-- Zona --}}
                                <td><span class="badge-zona">Z{{ $c->fk_id_zona }}</span></td>

                                {{-- Email --}}
                                <td>
                                    <div class="cell-truncate" style="font-size:0.82rem;color:#374151;" title="{{ $c->user?->email ?? '—' }}">
                                        {{ $c->user?->email ?? '—' }}
                                    </div>
                                </td>

                                {{-- Mesas --}}
                                <td>
                                    @if($c->puesto)
                                    <span class="badge-mesas">{{ $c->puesto->total_mesas }}</span>
                                    @else
                                    <span style="color:#d1d5db;">—</span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td>
                                    <div style="display:flex;gap:0.4rem;align-items:center;">
                                        <a href="{{ route('coordinadores.edit', $c) }}" class="btn-edit">Editar</a>
                                        <form method="POST" action="{{ route('coordinadores.destroy', $c) }}" style="margin:0;"
                                              onsubmit="return confirm('¿Eliminar a {{ addslashes($c->nombre) }}? También se eliminará su usuario.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-del">×</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="padding:0.75rem 1rem;border-top:1px solid #f3f4f6;font-size:0.78rem;color:#9ca3af;display:flex;justify-content:space-between;">
                    <span id="pie-conteo">{{ $coordinadores->count() }} coordinadores</span>
                    <span>Clave: número de documento</span>
                </div>
                @endif
            </div>

        </div>
    </div>

    <script>
    function filtrar() {
        const q = document.getElementById('buscador').value.toLowerCase().trim();
        const filas = document.querySelectorAll('.coord-row');
        let vis = 0;
        filas.forEach(function(f) {
            const ok = !q
                || f.dataset.nombre.includes(q)
                || f.dataset.documento.includes(q)
                || f.dataset.puesto.includes(q)
                || f.dataset.zona.includes(q)
                || f.dataset.email.includes(q);
            f.style.display = ok ? '' : 'none';
            if (ok) vis++;
        });
        const txt = vis + ' coordinador' + (vis !== 1 ? 'es' : '');
        document.getElementById('conteo').textContent = txt;
        document.getElementById('pie-conteo').textContent = txt;
    }
    </script>
</x-app-layout>
