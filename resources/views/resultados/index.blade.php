<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="padding: 1.75rem 2rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
                <div>
                    <h2 style="color:white; font-size:1.75rem; font-weight:800; margin:0; letter-spacing:-0.5px;">
                        Resultados de Votación
                    </h2>
                    <p style="color:rgba(255,255,255,0.75); margin:0.3rem 0 0; font-size:0.875rem;">
                        Votos de nuestros candidatos por elección · actualiza la página para ver nuevos datos
                    </p>
                </div>
                @if($municipioFiltro)
                <a href="{{ route('resultados.index') }}"
                   style="background:rgba(255,255,255,0.15); color:white; padding:0.5rem 1rem; border-radius:8px; text-decoration:none; font-size:0.82rem; font-weight:600; border:1px solid rgba(255,255,255,0.25);">
                    ✕ Quitar filtro
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <style>
        body { font-family:'Inter',sans-serif !important; background:#f1f5f9 !important; }

        .stats-top {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: white; border-radius: 14px;
            padding: 1.25rem 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        .stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; margin-bottom: 0.4rem; }
        .stat-value { font-size: 2rem; font-weight: 900; line-height: 1; }
        .stat-sub   { font-size: 0.75rem; color: #9ca3af; margin-top: 0.25rem; }

        .elec-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .filter-row { display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; margin-bottom: 1.25rem; }
        .filter-select {
            padding: 0.55rem 1rem; border: 2px solid #e5e7eb; border-radius: 8px;
            font-size: 0.9rem; color: #1f2937; background: white; cursor: pointer; font-weight: 500;
        }
        .filter-select:focus { outline: none; border-color: #2563eb; }

        .section-card {
            background: white; border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 1.5rem; overflow: hidden;
        }
        .section-title {
            padding: 1rem 1.5rem; border-bottom: 1px solid #f3f4f6;
            font-size: 1rem; font-weight: 700; color: #111827;
            display: flex; align-items: center; gap: 0.5rem;
        }

        /* Ranking */
        .ranking-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(380px, 1fr)); gap: 0; }
        .ranking-col  { border-right: 1px solid #f3f4f6; }
        .ranking-col:last-child { border-right: none; }
        .ranking-elec-header {
            padding: 0.65rem 1.25rem; font-size: 0.8rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px; color: white;
            display: flex; align-items: center; justify-content: space-between;
        }
        .ranking-table { width: 100%; border-collapse: collapse; }
        .ranking-table th {
            padding: 0.55rem 1rem; text-align: left; font-size: 0.68rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
            color: #6b7280; background: #f9fafb; border-bottom: 1px solid #f3f4f6;
        }
        .ranking-table td { padding: 0.6rem 1rem; font-size: 0.85rem; border-bottom: 1px solid #f9fafb; vertical-align: middle; }
        .ranking-table tr:last-child td { border-bottom: none; }
        .ranking-table tr.row-propio td { background: #f0fdf4; }
        .ranking-table tr.row-propio:hover td { background: #dcfce7; }
        .ranking-table tr:not(.row-propio):hover td { background: #f9fafb; }
        .bar-wrap { width: 100px; height: 7px; background: #e5e7eb; border-radius: 4px; overflow: hidden; display:inline-block; vertical-align:middle; }
        .bar-fill  { height: 100%; border-radius: 4px; }

        /* Tabla de mesas */
        .mesas-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
        .mesas-table th {
            padding: 0.55rem 0.75rem; text-align: left; font-size: 0.68rem;
            font-weight: 700; text-transform: uppercase; color: #6b7280;
            background: #f9fafb; border-bottom: 1px solid #e5e7eb; white-space: nowrap;
        }
        .mesas-table td { padding: 0.45rem 0.75rem; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }

        .mun-header {
            padding: 0.7rem 1.25rem; background: linear-gradient(135deg, #1e3a5f 0%, #1d4ed8 100%);
            color: white; display: flex; align-items: center; justify-content: space-between;
            gap: 1rem; flex-wrap: wrap; cursor: pointer; user-select: none;
        }
        .mun-nombre { font-size: 0.95rem; font-weight: 800; letter-spacing: 0.3px; }
        .mun-stats  { display:flex; gap:1rem; font-size:0.75rem; color:rgba(255,255,255,0.85); flex-wrap:wrap; }
        .mun-stat   { display:flex; flex-direction:column; align-items:center; }
        .mun-stat strong { font-size:1rem; font-weight:800; color:white; }

        .puesto-header {
            padding: 0.5rem 1.25rem; background: #eff6ff;
            border-bottom: 1px solid #dbeafe;
            display: flex; align-items: center; justify-content: space-between;
            gap: 0.75rem; flex-wrap: wrap;
        }
        .puesto-nombre { font-weight: 700; color: #1e40af; font-size: 0.85rem; }
        .puesto-mini   { font-size: 0.72rem; color: #3b82f6; }

        .chip { display:inline-flex; align-items:center; padding:0.15rem 0.5rem; border-radius:20px; font-size:0.65rem; font-weight:700; white-space:nowrap; }
        .chip-ok      { background:#dcfce7; color:#166534; }
        .chip-pending { background:#fef3c7; color:#92400e; }
        .chip-locked  { background:#ffedd5; color:#9a3412; }

        .votos-propio { font-weight: 800; color: #15803d; }
        .votos-empty  { color: #d1d5db; font-style: italic; }

        .progress-bar { height: 5px; background: #e5e7eb; border-radius: 3px; overflow: hidden; min-width: 50px; display:inline-block; vertical-align:middle; }
        .progress-fill { height: 100%; border-radius: 3px; }

        @media (max-width: 768px) {
            .stats-top { grid-template-columns: repeat(2,1fr); }
            .ranking-grid { grid-template-columns: 1fr; }
            .ranking-col { border-right: none; border-bottom: 1px solid #f3f4f6; }
            .elec-stats-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div style="padding: 1.75rem 0 3rem;">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 1rem;">

            {{-- ── STATS GLOBALES (solo nuestros votos) ── --}}
            @php $pctMesas = $totalMesas > 0 ? round($mesasReportadas / $totalMesas * 100, 1) : 0; @endphp
            <div class="stats-top">
                <div class="stat-card" style="border-top:4px solid #16a34a;">
                    <div class="stat-label">Total votos nuestros</div>
                    <div class="stat-value" style="color:#15803d;">{{ number_format($totalVotosPropio) }}</div>
                    <div class="stat-sub">suma de todas las elecciones</div>
                </div>
                <div class="stat-card" style="border-top:4px solid #2563eb;">
                    <div class="stat-label">Mesas con reporte</div>
                    <div class="stat-value" style="color:#1d4ed8;">{{ number_format($mesasReportadas) }}</div>
                    <div class="stat-sub">de {{ number_format($totalMesas) }} · {{ $pctMesas }}%</div>
                </div>
                <div class="stat-card" style="border-top:4px solid #7c3aed;">
                    <div class="stat-label">Elecciones activas</div>
                    <div class="stat-value" style="color:#6d28d9;">{{ $elecciones->count() }}</div>
                    <div class="stat-sub">con candidatos propios</div>
                </div>
            </div>

            {{-- ── RESUMEN POR ELECCIÓN (solo votos propios) ── --}}
            <div class="elec-stats-grid">
                @foreach($elecciones as $eleccion)
                @php $propios = $eleccion->ranking->where('tipo', 'propio'); @endphp
                <div style="background:white; border-radius:16px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
                    <div style="background:{{ $eleccion->color }}; padding:0.85rem 1.25rem; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="color:white; font-weight:800; font-size:1rem;">{{ $eleccion->nombre }}</div>
                            <div style="color:rgba(255,255,255,0.8); font-size:0.75rem;">{{ ucfirst($eleccion->tipo_cargo) }}</div>
                        </div>
                        <div style="text-align:right;">
                            <div style="color:white; font-size:1.5rem; font-weight:900; line-height:1;">{{ number_format($eleccion->votos_propio) }}</div>
                            <div style="color:rgba(255,255,255,0.8); font-size:0.7rem;">votos nuestros</div>
                        </div>
                    </div>
                    <div style="padding:0.9rem 1.25rem;">
                        <div style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:#6b7280; margin-bottom:0.5rem;">Nuestros candidatos</div>
                        @foreach($propios as $c)
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:0.3rem 0; border-bottom:1px solid #f9fafb;">
                            <span style="font-size:0.875rem; font-weight:700; color:#15803d;">{{ $c->nombre }}</span>
                            <span style="font-size:1.1rem; font-weight:900; color:#15803d;">{{ number_format($c->total_votos) }}</span>
                        </div>
                        @endforeach
                        <div style="margin-top:0.6rem; font-size:0.72rem; color:#9ca3af; text-align:right;">
                            Ver candidatos individuales en el ranking ↓
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ── FILTRO MUNICIPIO ── --}}
            <div class="filter-row">
                <form method="GET" action="{{ route('resultados.index') }}" style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;">
                    <label style="font-size:0.82rem;font-weight:700;color:#374151;">Filtrar municipio:</label>
                    <select name="municipio" class="filter-select" onchange="this.form.submit()">
                        <option value="">Todos los municipios</option>
                        @foreach($municipios as $m)
                            <option value="{{ $m->municipio_codigo }}" {{ $municipioFiltro == $m->municipio_codigo ? 'selected' : '' }}>
                                {{ $m->municipio_nombre }}
                            </option>
                        @endforeach
                    </select>
                    @if($municipioFiltro)
                        <a href="{{ route('resultados.index') }}" style="font-size:0.82rem;color:#6b7280;text-decoration:none;font-weight:600;">✕ Ver todos</a>
                    @endif
                </form>
            </div>

            {{-- ── RANKING POR ELECCIÓN (candidatos individuales) ── --}}
            <div class="section-card">
                <div class="section-title">
                    <svg style="width:1.1rem;height:1.1rem;color:#2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Ranking de Candidatos por Elección — votos individuales
                </div>
                <div class="ranking-grid">
                    @foreach($elecciones as $eleccion)
                    @php
                        $maxV = $eleccion->ranking->max('total_votos') ?: 1;
                        $pos  = 0;
                    @endphp
                    <div class="ranking-col">
                        <div class="ranking-elec-header" style="background:{{ $eleccion->color }};">
                            <span>{{ $eleccion->nombre }}</span>
                            <span style="background:rgba(255,255,255,0.2);padding:0.15rem 0.6rem;border-radius:10px;font-size:0.65rem;">
                                {{ $eleccion->ranking->count() }} candidatos
                            </span>
                        </div>
                        <table class="ranking-table">
                            <thead>
                                <tr>
                                    <th style="width:30px;">#</th>
                                    <th>Candidato</th>
                                    <th style="width:150px;">Proporción</th>
                                    <th style="text-align:right;width:70px;">Votos</th>
                                    <th style="width:60px;">Mesas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eleccion->ranking as $cand)
                                @php $pos++; $esPropio = $cand->tipo === 'propio'; @endphp
                                <tr class="{{ $esPropio ? 'row-propio' : '' }}">
                                    <td style="font-weight:800;color:{{ $pos <= 3 ? '#f59e0b' : '#9ca3af' }};font-size:0.85rem;">{{ $pos }}</td>
                                    <td>
                                        <span style="font-weight:{{ $esPropio ? '800' : '500' }};color:{{ $esPropio ? '#15803d' : '#1f2937' }};font-size:0.82rem;">
                                            {{ $cand->nombre }}
                                        </span>
                                        @if($esPropio)
                                            <span style="margin-left:0.3rem;font-size:0.6rem;background:#dcfce7;color:#166534;padding:0.1rem 0.4rem;border-radius:20px;font-weight:700;">NUESTRA</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="bar-wrap">
                                            <div class="bar-fill" style="width:{{ $maxV > 0 ? round($cand->total_votos/$maxV*100) : 0 }}%;background:{{ $esPropio ? '#16a34a' : '#6b7280' }};"></div>
                                        </div>
                                    </td>
                                    <td style="text-align:right;font-weight:800;color:{{ $esPropio ? '#15803d' : '#374151' }};">
                                        {{ number_format($cand->total_votos) }}
                                    </td>
                                    <td style="color:#9ca3af;font-size:0.78rem;">{{ $cand->num_mesas }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── DETALLE POR MUNICIPIO → PUESTO → MESA ── --}}
            <div class="section-card">
                <div class="section-title">
                    <svg style="width:1.1rem;height:1.1rem;color:#2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Votos Nuestros por Municipio · Puesto · Mesa
                    <span style="font-size:0.75rem;font-weight:500;color:#9ca3af;margin-left:0.5rem;">clic en municipio para expandir/colapsar</span>
                </div>

                @if(empty($porMunicipio))
                    <div style="padding:2.5rem;text-align:center;color:#9ca3af;">No hay mesas registradas.</div>
                @else
                @foreach($porMunicipio as $munCodigo => $mun)
                @php
                    $munNuestros = array_sum(array_column($mun['votos_por_elec'], 'propio'));
                @endphp
                <div class="municipio-block" id="mun-{{ $munCodigo }}">
                    <div class="mun-header" onclick="toggleMun('{{ $munCodigo }}')">
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <svg id="arrow-{{ $munCodigo }}" style="width:1rem;height:1rem;transition:transform 0.2s;transform:rotate(90deg);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="mun-nombre">{{ $mun['nombre'] }}</span>
                        </div>
                        <div class="mun-stats">
                            @foreach($elecciones as $eleccion)
                            @php $me = $mun['votos_por_elec'][$eleccion->id] ?? null; @endphp
                            @if($me && $me['propio'] > 0)
                            <div class="mun-stat">
                                <strong style="color:#86efac;">{{ number_format($me['propio']) }}</strong>
                                <span style="font-size:0.65rem;">{{ $eleccion->nombre }}</span>
                            </div>
                            @endif
                            @endforeach
                            <div class="mun-stat">
                                <strong>{{ $mun['mesas_reportadas'] }}/{{ $mun['total_mesas'] }}</strong>
                                <span>Mesas</span>
                            </div>
                        </div>
                    </div>

                    <div id="body-{{ $munCodigo }}">
                    @foreach($mun['puestos'] as $puestoId => $puesto)
                    @php
                        $puestoNuestros = array_sum(array_column($puesto['votos_por_elec'], 'propio'));
                    @endphp
                    <div>
                        <div class="puesto-header">
                            <span class="puesto-nombre">{{ $puesto['nombre'] }}</span>
                            <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
                                @foreach($elecciones as $eleccion)
                                @php $pe = $puesto['votos_por_elec'][$eleccion->id] ?? null; @endphp
                                @if($pe && $pe['propio'] > 0)
                                <span class="puesto-mini" style="display:inline-flex;align-items:center;gap:0.35rem;">
                                    <span style="background:{{ $eleccion->color }};color:white;padding:0.1rem 0.45rem;border-radius:4px;font-size:0.62rem;font-weight:700;">{{ $eleccion->nombre }}</span>
                                    <strong style="color:#15803d;">{{ number_format($pe['propio']) }}</strong>
                                    <span style="color:#9ca3af;font-size:0.68rem;">votos nuestros</span>
                                </span>
                                @endif
                                @endforeach
                                <span class="puesto-mini">
                                    {{ $puesto['mesas_reportadas'] }}/{{ count($puesto['mesas']) }} mesas
                                    <span style="display:inline-block;margin-left:0.4rem;">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width:{{ count($puesto['mesas'])>0 ? round($puesto['mesas_reportadas']/count($puesto['mesas'])*100) : 0 }}%;background:#2563eb;"></div>
                                        </div>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <table class="mesas-table">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align:bottom;">Mesa</th>
                                    <th rowspan="2" style="vertical-align:bottom;">Testigo</th>
                                    @foreach($elecciones as $eleccion)
                                    <th style="text-align:center;border-left:2px solid #e5e7eb;background:{{ $eleccion->color }}20;color:{{ $eleccion->color }};padding:0.4rem 0.6rem;">
                                        {{ $eleccion->nombre }}
                                    </th>
                                    @endforeach
                                    <th rowspan="2" style="vertical-align:bottom;">Estado</th>
                                </tr>
                                <tr>
                                    @foreach($elecciones as $eleccion)
                                    <th style="border-left:2px solid #e5e7eb;color:#15803d;background:{{ $eleccion->color }}10;text-align:center;">
                                        Nuestros votos
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($puesto['mesas'] as $mesa)
                            <tr>
                                <td style="font-weight:700;color:#374151;">Mesa #{{ $mesa['numero'] }}</td>
                                <td style="color:#6b7280;font-size:0.75rem;">{{ $mesa['testigo'] ?? '—' }}</td>
                                @foreach($elecciones as $eleccion)
                                @php
                                    $me  = $mesa['votos_por_elec'][$eleccion->id] ?? null;
                                    $rpt = $me && $me['reportada'];
                                @endphp
                                <td style="border-left:2px solid #f3f4f6;text-align:center;">
                                    @if($rpt)
                                        <span class="votos-propio" style="font-size:1rem;">{{ number_format($me['propio']) }}</span>
                                    @else
                                        <span class="votos-empty">—</span>
                                    @endif
                                </td>
                                @endforeach
                                <td>
                                    @if(!$mesa['reportada'])
                                        <span class="chip chip-pending">Pendiente</span>
                                    @else
                                        @php $todasBloq = collect($mesa['votos_por_elec'])->every(fn($e) => $e['bloqueada'] ?? false); @endphp
                                        @if($todasBloq)
                                            <span class="chip chip-locked">Bloqueada</span>
                                        @else
                                            <span class="chip chip-ok">Parcial</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                    </div>
                </div>
                @endforeach
                @endif
            </div>

        </div>
    </div>

    <script>
        function toggleMun(codigo) {
            const body  = document.getElementById('body-' + codigo);
            const arrow = document.getElementById('arrow-' + codigo);
            if (body.style.display === 'none') {
                body.style.display  = '';
                arrow.style.transform = 'rotate(90deg)';
            } else {
                body.style.display  = 'none';
                arrow.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-app-layout>
