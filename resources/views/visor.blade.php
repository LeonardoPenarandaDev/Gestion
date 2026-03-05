<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1920">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Electoral EN VIVO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            width: 1920px;
            height: 1080px;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #1f2937;
        }

        /* ══ Shell ══ */
        .shell {
            display: flex;
            flex-direction: column;
            width: 1920px;
            height: 1080px;
        }

        /* ══ Header ══ */
        .hdr {
            flex-shrink: 0;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 4px 16px rgba(102,126,234,0.35);
        }
        .hdr-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .hdr-sub { font-size: 0.85rem; color: rgba(255,255,255,0.7); font-weight: 400; }
        .hdr-sep { color: rgba(255,255,255,0.3); }
        .badge-live {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.4);
            color: white; font-size: 0.72rem; font-weight: 800;
            letter-spacing: 1.5px; padding: 0.3rem 0.9rem;
            border-radius: 20px; text-transform: uppercase;
        }
        .badge-live .dot {
            width: 7px; height: 7px;
            background: #4ade80; border-radius: 50%;
            animation: blink 1.4s ease-in-out infinite;
        }
        .clock {
            font-size: 1.8rem; font-weight: 700;
            color: white; letter-spacing: 2px;
            font-variant-numeric: tabular-nums;
        }

        /* ══ Contenido ══ */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 14px 18px;
            overflow: hidden;
        }

        /* ══ Tarjeta base ══ */
        .card {
            background: rgba(255,255,255,0.95);
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .card-body { padding: 14px 16px; }
        .card-head {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        .card-head-title {
            font-size: 0.9rem; font-weight: 700; color: #374151;
            display: flex; align-items: center; gap: 0.5rem;
        }

        /* ══ Fila 1 ══ */
        .row1 {
            flex-shrink: 0;
            display: grid;
            grid-template-columns: 1fr 460px;
            gap: 14px;
            height: 246px;
        }

        /* Elecciones configuradas */
        .elections-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 12px 14px;
            height: calc(246px - 45px);
        }
        .elec-mini {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
        }
        .elec-mini-hdr {
            padding: 8px 12px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .elec-mini-name { font-size: 0.95rem; font-weight: 800; color: white; }
        .elec-mini-date { font-size: 0.72rem; color: rgba(255,255,255,0.8); }
        .badge-activa {
            background: rgba(255,255,255,0.25); color: white;
            font-size: 0.65rem; font-weight: 700; padding: 0.15rem 0.55rem;
            border-radius: 12px; white-space: nowrap;
            display: flex; align-items: center; gap: 0.25rem;
        }
        .elec-mini-stats {
            flex: 1;
            display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0;
            padding: 10px 12px 8px;
        }
        .elec-stat { text-align: center; }
        .elec-stat-val { font-size: 1.6rem; font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; }
        .elec-stat-lbl { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; margin-top: 2px; }
        .elec-mini-bar { padding: 0 12px 8px; }
        .elec-bar-track { height: 6px; background: #f3f4f6; border-radius: 3px; overflow: hidden; }
        .elec-bar-fill { height: 100%; border-radius: 3px; transition: width 0.6s ease; }
        .elec-mini-footer {
            padding: 6px 12px;
            background: #f9fafb;
            font-size: 0.7rem; color: #6b7280;
            display: flex; justify-content: space-between;
        }

        /* Resumen general */
        .resumen-grid {
            display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr;
            gap: 10px; padding: 12px 14px;
            height: calc(246px - 45px);
        }
        .stat-tile {
            border-radius: 10px; padding: 10px 14px;
            display: flex; flex-direction: column; justify-content: center;
        }
        .stat-tile-val { font-size: 2rem; font-weight: 800; font-variant-numeric: tabular-nums; line-height: 1; }
        .stat-tile-lbl { font-size: 0.68rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }

        /* ══ Fila 2 ══ */
        .row2 {
            flex-shrink: 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            height: 210px;
        }
        .chart-row {
            display: flex; align-items: center; gap: 16px;
            padding: 10px 14px;
        }
        .chart-canvas-wrap { flex-shrink: 0; width: 120px; height: 120px; }
        .chart-bars { flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .bar-item {}
        .bar-meta { display: flex; justify-content: space-between; font-size: 0.75rem; color: #374151; font-weight: 600; margin-bottom: 3px; }
        .bar-track { height: 7px; background: #e5e7eb; border-radius: 4px; overflow: hidden; }
        .bar-fill { height: 100%; border-radius: 4px; transition: width 0.6s ease; }
        .chart-pct-box {
            margin-top: 8px; text-align: center;
            padding: 5px 10px; border-radius: 8px;
        }
        .chart-pct-val { font-size: 1.3rem; font-weight: 800; font-variant-numeric: tabular-nums; }
        .chart-pct-lbl { font-size: 0.65rem; font-weight: 600; display: block; margin-top: 1px; }

        /* ══ Fila 3 ══ */
        .row3 {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            overflow: hidden;
            min-height: 0;
        }

        /* Ranking candidatos */
        .rank-table-wrap { flex: 1; overflow: hidden; }
        .rank-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .rank-table thead th {
            padding: 6px 10px; text-align: left;
            font-weight: 600; color: #374151;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.72rem;
            position: sticky; top: 0;
        }
        .rank-table tbody td {
            padding: 4px 10px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.75rem;
            color: #374151;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .rank-propio > td { background: #f0fdf4; }
        .rank-propio > td:first-child { border-left: 3px solid #16a34a; }
        .rank-num { color: #9ca3af; font-weight: 700; font-size: 0.68rem; width: 24px; padding-right: 4px !important; }
        .rank-votes { font-weight: 700; font-variant-numeric: tabular-nums; }
        .rank-badge-propio {
            font-size: 0.58rem; background: #dcfce7; color: #16a34a;
            padding: 1px 4px; border-radius: 6px; margin-left: 3px;
            vertical-align: middle; font-weight: 700; letter-spacing: 0.3px;
        }
        .rank-bar-mini { height: 4px; background: #e5e7eb; border-radius: 2px; overflow: hidden; }
        .rank-bar-fill { height: 100%; border-radius: 2px; transition: width 0.6s ease; }
        .rep-card { display: flex; flex-direction: column; overflow: hidden; }
        .rep-card-hdr {
            flex-shrink: 0;
            padding: 10px 16px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .rep-card-hdr-title { font-size: 1rem; font-weight: 700; color: white; }
        .rep-card-hdr-sub { font-size: 0.72rem; color: rgba(255,255,255,0.8); margin-top: 1px; }
        .rep-card-hdr-badge {
            background: rgba(255,255,255,0.2); color: white;
            font-size: 0.8rem; font-weight: 700;
            padding: 0.25rem 0.75rem; border-radius: 8px; white-space: nowrap;
        }
        .rep-table-wrap { flex: 1; overflow: hidden; }
        .rep-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .rep-table thead th {
            padding: 8px 12px; text-align: left;
            font-weight: 600; color: #374151;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.78rem;
            position: sticky; top: 0;
        }
        .rep-table tbody td {
            padding: 8px 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.82rem;
            color: #374151;
        }
        .rep-table tbody tr:hover td { background: #f9fafb; }
        .mesa-badge {
            display: inline-block; color: white;
            padding: 2px 9px; border-radius: 20px;
            font-weight: 700; font-size: 0.75rem;
        }
        .votos-badge {
            background: #dcfce7; color: #166534;
            padding: 2px 9px; border-radius: 12px;
            font-weight: 700; font-size: 0.8rem;
            display: inline-block;
        }
        .foto-link {
            display: inline-flex; align-items: center; gap: 3px;
            color: #059669; font-weight: 500; font-size: 0.72rem;
            background: #f0fdf4; border: 1px solid #86efac;
            border-radius: 6px; padding: 2px 6px; text-decoration: none;
        }

        /* ══ Animations ══ */
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.2} }
        @keyframes flashNum { 0%,100%{opacity:1} 40%{opacity:0.35} }
        .flash { animation: flashNum 0.5s ease; }
    </style>
</head>
<body>
<div class="shell">

    {{-- ══════ HEADER ══════ --}}
    <header class="hdr">
        <div class="hdr-title">
            <svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Panel Electoral
            <span class="hdr-sep">·</span>
            <span class="hdr-sub">Elecciones Congreso 2026 · E14</span>
        </div>
        <div class="badge-live"><span class="dot"></span>EN VIVO</div>
        <div class="clock" id="vclock">{{ now()->format('H:i:s') }}</div>
    </header>

    {{-- ══════ CONTENIDO ══════ --}}
    <div class="content">

        {{-- ── Fila 1: Elecciones + Resumen ── --}}
        <div class="row1">

            {{-- Elecciones Configuradas --}}
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="16" height="16" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Elecciones Configuradas
                    </div>
                    <a href="{{ route('elecciones.index') }}"
                       style="font-size:0.72rem;font-weight:600;color:#667eea;text-decoration:none;background:#f3f0ff;padding:0.25rem 0.75rem;border-radius:20px;">
                        Gestionar →
                    </a>
                </div>
                <div class="elections-grid">
                    @foreach($elecciones as $elec)
                    @php
                        $ec       = $elec->color ?? '#667eea';
                        $tot      = $elec->votos_propio + $elec->votos_competencia;
                        $pctProp  = $tot > 0 ? round($elec->votos_propio / $tot * 100, 1) : 0;
                        $ventaja  = $elec->votos_propio - $elec->votos_competencia;
                        $ventLabel= $ventaja > 0 ? 'Ventaja' : ($ventaja < 0 ? 'Déficit' : 'Empate');
                        $ventColor= $ventaja > 0 ? '#16a34a' : ($ventaja < 0 ? '#dc2626' : '#6b7280');
                    @endphp
                    <div class="elec-mini">
                        <div class="elec-mini-hdr" style="background:{{ $ec }};">
                            <div>
                                <div class="elec-mini-name">{{ $elec->nombre }}</div>
                                <div class="elec-mini-date">{{ ucfirst($elec->tipo_cargo) }} · {{ $elec->fecha?->format('d/m/Y') }}</div>
                            </div>
                            @if($elec->activa)
                            <div class="badge-activa">
                                <span style="width:6px;height:6px;background:#4ade80;border-radius:50%;display:inline-block;"></span>
                                Activa
                            </div>
                            @endif
                        </div>
                        <div class="elec-mini-stats">
                            <div class="elec-stat">
                                <div class="elec-stat-val" style="color:#16a34a;"
                                     id="vp_{{ $elec->id }}">{{ number_format($elec->votos_propio) }}</div>
                                <div class="elec-stat-lbl">Nuestros</div>
                            </div>
                            <div class="elec-stat">
                                <div class="elec-stat-val" style="color:#dc2626;"
                                     id="vc_{{ $elec->id }}">{{ number_format($elec->votos_competencia) }}</div>
                                <div class="elec-stat-lbl">Compet.</div>
                            </div>
                            <div class="elec-stat">
                                <div class="elec-stat-val" style="color:{{ $ventColor }};"
                                     id="vv_{{ $elec->id }}">{{ $ventaja >= 0 ? '+' : '' }}{{ number_format($ventaja) }}</div>
                                <div class="elec-stat-lbl">{{ $ventLabel }}</div>
                            </div>
                        </div>
                        <div class="elec-mini-bar">
                            <div class="elec-bar-track">
                                <div class="elec-bar-fill" id="ef_{{ $elec->id }}"
                                     style="width:{{ $pctProp }}%; background:{{ $ec }};"></div>
                            </div>
                        </div>
                        <div class="elec-mini-footer">
                            <span id="ep_{{ $elec->id }}">{{ $pctProp }}% nuestros</span>
                            <span>{{ $elec->candidatos_count }} candidatos activos</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Resumen General --}}
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="16" height="16" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Resumen General
                    </div>
                </div>
                <div class="resumen-grid">
                    <div class="stat-tile" style="background:#dbeafe;">
                        <div class="stat-tile-val" style="color:#1d4ed8;" id="vPuestos">{{ number_format($totalPuestos) }}</div>
                        <div class="stat-tile-lbl" style="color:#1e40af;">Puestos</div>
                    </div>
                    <div class="stat-tile" style="background:#fef3c7;">
                        <div class="stat-tile-val" style="color:#d97706;" id="vTestigos">{{ number_format($totalTestigos) }}</div>
                        <div class="stat-tile-lbl" style="color:#92400e;">Testigos</div>
                    </div>
                    <div class="stat-tile" style="background:#dcfce7;">
                        <div class="stat-tile-val" style="color:#16a34a;" id="vMesasRep">{{ number_format($mesasReportadas) }}</div>
                        <div class="stat-tile-lbl" style="color:#166534;">Mesas Reportadas</div>
                    </div>
                    <div class="stat-tile" style="background:#f3e8ff;">
                        <div class="stat-tile-val" style="color:#7c3aed;" id="vTotalMesas">{{ number_format($totalMesas) }}</div>
                        <div class="stat-tile-lbl" style="color:#6b21a8;">Total Mesas</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Fila 2: Cobertura + Progreso por elección ── --}}
        <div class="row2">

            {{-- Cobertura de Mesas --}}
            @php
                $pctCob = $totalMesas > 0 ? round($mesasCubiertas / $totalMesas * 100) : 0;
                $mesPendientes = $totalMesas - $mesasCubiertas;
            @endphp
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="16" height="16" fill="none" stroke="#10b981" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Cobertura de Mesas
                    </div>
                </div>
                <div class="chart-row">
                    <div class="chart-canvas-wrap">
                        <canvas id="chartCobertura"></canvas>
                    </div>
                    <div class="chart-bars">
                        <div class="bar-item">
                            <div class="bar-meta">
                                <span>Cubiertas</span>
                                <span style="color:#10b981;font-weight:700;" id="vMesasCub">{{ number_format($mesasCubiertas) }}</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" id="bCubiertas"
                                     style="width:{{ $pctCob }}%; background:linear-gradient(90deg,#10b981,#059669);"></div>
                            </div>
                        </div>
                        <div class="bar-item">
                            <div class="bar-meta">
                                <span>Pendientes</span>
                                <span style="color:#f59e0b;font-weight:700;" id="vMesPend">{{ number_format($mesPendientes) }}</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" id="bPendientes"
                                     style="width:{{ 100 - $pctCob }}%; background:linear-gradient(90deg,#f59e0b,#d97706);"></div>
                            </div>
                        </div>
                        <div class="chart-pct-box" style="background:#f0fdf4;">
                            <div class="chart-pct-val" style="color:#166534;" id="vPctCob">{{ $pctCob }}%</div>
                            <span class="chart-pct-lbl" style="color:#16a34a;">Cobertura</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progreso por elección --}}
            @foreach($elecciones as $elec)
            @php
                $repElec  = $elec->mesas_reportadas_elec ?? 0;
                $sinRep   = max(0, $mesasCubiertas - $repElec);
                $pctRep   = $mesasCubiertas > 0 ? round($repElec / $mesasCubiertas * 100) : 0;
                $ec       = $elec->color ?? '#667eea';
            @endphp
            <div class="card">
                <div class="card-head">
                    <div class="card-head-title">
                        <svg width="16" height="16" fill="none" stroke="{{ $ec }}" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Progreso de Reportes E14 — {{ $elec->nombre }}
                    </div>
                </div>
                <div class="chart-row">
                    <div class="chart-canvas-wrap">
                        <canvas id="chartProg_{{ $elec->id }}"></canvas>
                    </div>
                    <div class="chart-bars">
                        <div class="bar-item">
                            <div class="bar-meta">
                                <span>Reportadas</span>
                                <span style="color:#10b981;font-weight:700;" id="rRep_{{ $elec->id }}">{{ $repElec }}</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" id="bRep_{{ $elec->id }}"
                                     style="width:{{ $pctRep }}%; background:linear-gradient(90deg,#10b981,#059669);"></div>
                            </div>
                        </div>
                        <div class="bar-item">
                            <div class="bar-meta">
                                <span>Sin Reportar</span>
                                <span style="color:#ef4444;font-weight:700;" id="rSin_{{ $elec->id }}">{{ $sinRep }}</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" id="bSin_{{ $elec->id }}"
                                     style="width:{{ 100 - $pctRep }}%; background:linear-gradient(90deg,#ef4444,#dc2626);"></div>
                            </div>
                        </div>
                        <div class="chart-pct-box" style="background:#faf5ff;">
                            <div class="chart-pct-val" style="color:{{ $ec }};" id="rPct_{{ $elec->id }}">{{ $pctRep }}%</div>
                            <span class="chart-pct-lbl" style="color:{{ $ec }};">Reportado</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── Fila 3: Rankings + Reportes por elección ── --}}
        <div class="row3">
            @foreach($ultimosReportesPorEleccion as $elec)
            @php
                $ec             = $elec->color ?? '#667eea';
                $elecConRanking = $elecciones->firstWhere('id', $elec->id);
                $ranking        = $elecConRanking?->candidatos_ranking ?? collect();
                $maxV           = $ranking->max('total_votos') ?: 1;
            @endphp

            {{-- Ranking de candidatos --}}
            <div class="card rep-card">
                <div class="rep-card-hdr" style="background:{{ $ec }};">
                    <div>
                        <div class="rep-card-hdr-title">Votos por Candidato — {{ $elec->nombre }}</div>
                        <div class="rep-card-hdr-sub">{{ ucfirst($elec->tipo_cargo) }} · Ranking en tiempo real</div>
                    </div>
                    <div class="rep-card-hdr-badge">{{ $ranking->count() }} candidatos</div>
                </div>
                <div class="rank-table-wrap" id="rankTable_{{ $elec->id }}">
                    <table class="rank-table">
                        <thead>
                            <tr>
                                <th style="width:26px;">#</th>
                                <th>Candidato</th>
                                <th style="width:62px;text-align:right;">Votos</th>
                                <th style="width:68px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ranking as $i => $cand)
                            <tr class="{{ $cand->tipo === 'propio' ? 'rank-propio' : '' }}">
                                <td class="rank-num">{{ $i + 1 }}</td>
                                <td style="{{ $cand->tipo === 'propio' ? 'font-weight:700;color:#166534;' : '' }}">
                                    {{ $cand->nombre }}
                                    @if($cand->tipo === 'propio')
                                    <span class="rank-badge-propio">NUESTRO</span>
                                    @endif
                                </td>
                                <td style="text-align:right;{{ $cand->tipo === 'propio' ? 'color:#16a34a;' : '' }}" class="rank-votes">
                                    {{ number_format($cand->total_votos) }}
                                </td>
                                <td>
                                    <div class="rank-bar-mini">
                                        <div class="rank-bar-fill"
                                             style="width:{{ $maxV > 0 ? round($cand->total_votos / $maxV * 100) : 0 }}%;background:{{ $cand->tipo === 'propio' ? '#16a34a' : $ec }};"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($ranking->isEmpty())
                            <tr>
                                <td colspan="4" style="text-align:center;color:#9ca3af;padding:1.5rem;">
                                    Sin votos registrados aún
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Últimos Reportes --}}
            <div class="card rep-card">
                <div class="rep-card-hdr" style="background:{{ $ec }};">
                    <div>
                        <div class="rep-card-hdr-title">Últimos Reportes E14 — {{ $elec->nombre }}</div>
                        <div class="rep-card-hdr-sub">{{ ucfirst($elec->tipo_cargo) }} · {{ $elec->fecha?->format('d/m/Y') }}</div>
                    </div>
                    <div class="rep-card-hdr-badge" id="repCount_{{ $elec->id }}">
                        {{ $elec->ultimosReportes->count() }} reportes
                    </div>
                </div>
                <div class="rep-table-wrap" id="repTable_{{ $elec->id }}">
                    <table class="rep-table">
                        <thead>
                            <tr>
                                <th style="width:100px;">Mesa</th>
                                <th>Puesto</th>
                                <th style="width:120px;text-align:center;color:#166534;">Votos Nuestros</th>
                                <th style="width:120px;text-align:center;">Fotos E14</th>
                                <th style="width:110px;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($elec->ultimosReportes as $r)
                            <tr>
                                <td>
                                    <span class="mesa-badge" style="background:{{ $ec }};">
                                        Mesa #{{ $r->mesa->numero_mesa ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ $r->mesa?->puesto?->nombre ?? 'N/A' }}</td>
                                <td style="text-align:center;">
                                    @if($r->total_votos)
                                    <span class="votos-badge">{{ number_format($r->total_votos) }}</span>
                                    @else
                                    <span style="color:#9ca3af;">—</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    @if($r->imagen_acta && count($r->imagen_acta) > 0)
                                        @foreach($r->imagen_acta as $fi => $img)
                                        <a href="{{ Storage::url($img) }}" target="_blank" class="foto-link">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Foto {{ $fi + 1 }}
                                        </a>
                                        @endforeach
                                    @else
                                    <span style="color:#9ca3af;font-size:0.75rem;">Sin foto</span>
                                    @endif
                                </td>
                                <td style="color:#6b7280;">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center;color:#9ca3af;padding:1.5rem;">
                                    Sin reportes aún para {{ $elec->nombre }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>

    </div>{{-- fin content --}}
</div>{{-- fin shell --}}

<script>
// ── Reloj ──
function tick() {
    const n = new Date();
    document.getElementById('vclock').textContent =
        String(n.getHours()).padStart(2,'0') + ':' +
        String(n.getMinutes()).padStart(2,'0') + ':' +
        String(n.getSeconds()).padStart(2,'0');
}
setInterval(tick, 1000);

// ── Chart.js colores ──
const chartColors = {
    green : '#10b981',
    red   : '#ef4444',
    yellow: '#f59e0b',
    gray  : '#e5e7eb',
};

// ── Doughnut helper ──
function makeDoughnut(id, data, colors) {
    const ctx = document.getElementById(id);
    if (!ctx) return null;
    return new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.map(d => d.label),
            datasets: [{ data: data.map(d => d.val), backgroundColor: colors, borderWidth: 0, cutout: '72%' }]
        },
        options: {
            responsive: true, maintainAspectRatio: true,
            plugins: { legend: { display: false }, tooltip: { enabled: false } }
        }
    });
}

// Inicializar charts
const chartCob = makeDoughnut('chartCobertura',
    [{ label:'Cubiertas', val:{{ $mesasCubiertas }} }, { label:'Pendientes', val:{{ max(0,$totalMesas-$mesasCubiertas) }} }],
    [chartColors.green, chartColors.yellow]
);

@foreach($elecciones as $elec)
@php $repE = $elec->mesas_reportadas_elec ?? 0; @endphp
const chart_{{ $elec->id }} = makeDoughnut('chartProg_{{ $elec->id }}',
    [{ label:'Reportadas', val:{{ $repE }} }, { label:'Sin Reportar', val:{{ max(0,$mesasCubiertas-$repE) }} }],
    ['{{ $elec->color ?? "#667eea" }}', chartColors.gray]
);
@endforeach

// ── Helpers update ──
function upd(id, txt) {
    const el = document.getElementById(id);
    if (!el) return;
    if (el.textContent.trim() !== String(txt).trim()) {
        el.textContent = txt;
        el.classList.remove('flash'); void el.offsetWidth; el.classList.add('flash');
    }
}
function setW(id, pct) { const el=document.getElementById(id); if(el) el.style.width=Math.min(100,pct)+'%'; }
function fmt(n) { return Number(n).toLocaleString('es-CO'); }

function updateDoughnut(chart, vals) {
    if (!chart) return;
    chart.data.datasets[0].data = vals;
    chart.update('none');
}

// ── Polling cada 20s ──
function poll() {
    fetch('{{ route("visor.data") }}', {
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(d => {
        const mc = d.mesasCubiertas;
        const tm = d.totalMesas;

        // Resumen General
        upd('vPuestos',   fmt(d.totalPuestos ?? 0));
        upd('vTestigos',  fmt(d.totalTestigos));
        upd('vMesasRep',  fmt(d.mesasReportadas));
        upd('vTotalMesas',fmt(tm));

        // Cobertura
        const pctCob = tm > 0 ? Math.round(mc / tm * 100) : 0;
        upd('vMesasCub',  fmt(mc));
        upd('vMesPend',   fmt(tm - mc));
        upd('vPctCob',    pctCob + '%');
        setW('bCubiertas', pctCob);
        setW('bPendientes', 100 - pctCob);
        updateDoughnut(chartCob, [mc, tm - mc]);

        // Elecciones
        d.elecciones.forEach(e => {
            const tot  = e.votos_propio + e.votos_competencia;
            const pctP = tot > 0 ? (e.votos_propio / tot * 100).toFixed(1) : 0;
            const vent = e.votos_propio - e.votos_competencia;
            const pctR = mc > 0 ? Math.round(e.mesas_reportadas / mc * 100) : 0;
            const sinR = Math.max(0, mc - e.mesas_reportadas);

            upd('vp_' + e.id, fmt(e.votos_propio));
            upd('vc_' + e.id, fmt(e.votos_competencia));
            const vvEl = document.getElementById('vv_' + e.id);
            if (vvEl) { vvEl.textContent = (vent>=0?'+':'') + fmt(vent); vvEl.style.color = vent>=0?'#16a34a':'#dc2626'; }
            upd('ep_' + e.id, pctP + '% nuestros');
            setW('ef_' + e.id, pctP);
            upd('rRep_' + e.id, e.mesas_reportadas);
            upd('rSin_' + e.id, sinR);
            upd('rPct_' + e.id, pctR + '%');
            setW('bRep_' + e.id, pctR);
            setW('bSin_' + e.id, 100 - pctR);
            const ch = window['chart_' + e.id];
            if (ch) {
                ch.data.datasets[0].backgroundColor = [e.color, chartColors.gray];
                updateDoughnut(ch, [e.mesas_reportadas, sinR]);
            }
        });

        // Ranking de candidatos
        d.elecciones.forEach(e => {
            const rankWrap = document.getElementById('rankTable_' + e.id);
            if (!rankWrap || !e.candidatos || !e.candidatos.length) return;
            const maxV = Math.max(...e.candidatos.map(c => c.total_votos), 1);
            const rankRows = e.candidatos.map((c, i) => `
                <tr class="${c.tipo === 'propio' ? 'rank-propio' : ''}">
                    <td class="rank-num">${i+1}</td>
                    <td style="${c.tipo === 'propio' ? 'font-weight:700;color:#166534;' : ''}">
                        ${c.nombre}${c.tipo === 'propio' ? ' <span class="rank-badge-propio">NUESTRO</span>' : ''}
                    </td>
                    <td style="text-align:right;${c.tipo === 'propio' ? 'color:#16a34a;' : ''}" class="rank-votes">${fmt(c.total_votos)}</td>
                    <td><div class="rank-bar-mini"><div class="rank-bar-fill" style="width:${Math.round(c.total_votos/maxV*100)}%;background:${c.tipo==='propio'?'#16a34a':e.color};"></div></div></td>
                </tr>`).join('');
            const tbody = rankWrap.querySelector('tbody');
            if (tbody) tbody.innerHTML = rankRows;
        });

        // Tablas de reportes
        d.reportesPorEleccion.forEach(elec => {
            const wrap = document.getElementById('repTable_' + elec.id);
            const badge = document.getElementById('repCount_' + elec.id);
            if (badge) badge.textContent = elec.reportes.length + ' reportes';
            if (!wrap) return;
            const rows = elec.reportes.length
                ? elec.reportes.map(r => `
                    <tr>
                        <td><span class="mesa-badge" style="background:${elec.color};">Mesa #${r.mesa}</span></td>
                        <td>${r.puesto}</td>
                        <td style="text-align:center;">
                            ${r.total_votos ? `<span class="votos-badge">${fmt(r.total_votos)}</span>` : '<span style="color:#9ca3af;">—</span>'}
                        </td>
                        <td style="text-align:center;">
                            ${r.imagen_acta && r.imagen_acta.length
                                ? r.imagen_acta.map((img,i) => `<a href="/storage/${img}" target="_blank" class="foto-link">Foto ${i+1}</a>`).join(' ')
                                : '<span style="color:#9ca3af;font-size:0.75rem;">Sin foto</span>'}
                        </td>
                        <td style="color:#6b7280;">${r.fecha}</td>
                    </tr>`).join('')
                : `<tr><td colspan="5" style="text-align:center;color:#9ca3af;padding:1.5rem;">Sin reportes aún</td></tr>`;

            const tbody = wrap.querySelector('tbody');
            if (tbody) tbody.innerHTML = rows;
        });

        upd('vclock', d.hora);
    })
    .catch(() => {});
}

setInterval(poll, 20000);
</script>
</body>
</html>
