<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
            <h2 style="font-size:1.05rem;font-weight:700;color:#1f2937;margin:0;display:flex;align-items:center;gap:0.6rem;">
                <svg width="18" height="18" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                </svg>
                Dashboard Electoral
                <span style="color:#d1d5db;">·</span>
                <span style="font-weight:500;color:#6b7280;font-size:0.9rem;">{{ now()->locale('es')->isoFormat('D MMM YYYY') }}</span>
            </h2>
            <span style="display:inline-flex;align-items:center;gap:0.35rem;background:#dcfce7;color:#16a34a;font-size:0.72rem;font-weight:700;padding:0.25rem 0.75rem;border-radius:20px;letter-spacing:0.3px;">
                <span style="width:6px;height:6px;background:#16a34a;border-radius:50%;display:inline-block;animation:dash-pulse 2s infinite;"></span>
                EN VIVO
            </span>
        </div>
    </x-slot>

    <style>
        body { font-family:'Inter',sans-serif !important; background:#f1f5f9 !important; }

        @keyframes dash-pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

        .d-card {
            background:white;
            border-radius:14px;
            box-shadow:0 2px 8px rgba(0,0,0,0.07);
            transition:transform 0.18s,box-shadow 0.18s;
        }
        .d-card-hover:hover {
            transform:translateY(-2px);
            box-shadow:0 6px 18px rgba(0,0,0,0.1);
        }

        .prog-track { background:#f3f4f6; border-radius:4px; height:6px; overflow:hidden; }
        .prog-fill  { height:100%; border-radius:4px; }

        .report-row { display:flex; align-items:center; gap:0.75rem; padding:0.55rem 0; border-bottom:1px solid #f3f4f6; }
        .report-row:last-child { border-bottom:none; }

        .q-link {
            display:flex; align-items:center; gap:0.7rem;
            padding:0.6rem 0.75rem; border-radius:9px;
            text-decoration:none; color:#374151;
            font-size:0.84rem; font-weight:600;
            transition:background 0.13s;
        }
        .q-link:hover { background:#f3f4f6; color:#1f2937; }

        @media(max-width:900px) {
            .dash-cols { grid-template-columns:1fr !important; }
            .stats-bar  { grid-template-columns:repeat(2,1fr) !important; }
        }
        @media(max-width:540px) {
            .hero-grid  { grid-template-columns:1fr !important; }
            .stats-bar  { grid-template-columns:repeat(2,1fr) !important; }
        }
    </style>

    <div style="padding:1.5rem 0;">
    <div style="max-width:1400px;margin:0 auto;padding:0 1.25rem;">

        {{-- ═══════════════════════════════════════
             HERO: Franja por Elección
        ═══════════════════════════════════════ --}}
        <div class="hero-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1rem;margin-bottom:1.1rem;">
            @foreach($elecciones as $elec)
            @php
                $ventaja = $elec->votos_propio - $elec->votos_competencia;
                $pctMesas = $mesasCubiertas > 0 ? round($mesasReportadas / $mesasCubiertas * 100) : 0;
                $elecColor = $elec->color ?? '#667eea';
            @endphp
            <div class="d-card d-card-hover" style="padding:1.25rem 1.4rem;border-top:4px solid {{ $elecColor }};">
                {{-- Encabezado elección --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem;">
                    <div style="font-size:0.7rem;text-transform:uppercase;font-weight:700;color:#9ca3af;letter-spacing:0.5px;">
                        {{ $elec->nombre }}
                    </div>
                    @if($elec->activa)
                    <span style="background:#dcfce7;color:#16a34a;font-size:0.65rem;font-weight:700;padding:0.1rem 0.45rem;border-radius:6px;">ACTIVA</span>
                    @else
                    <span style="background:#f3f4f6;color:#9ca3af;font-size:0.65rem;font-weight:700;padding:0.1rem 0.45rem;border-radius:6px;">INACTIVA</span>
                    @endif
                </div>

                <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
                    {{-- Votos propios --}}
                    <div>
                        <div style="font-size:2.4rem;font-weight:800;color:{{ $elecColor }};line-height:1;">
                            {{ number_format($elec->votos_propio) }}
                        </div>
                        <div style="font-size:0.72rem;color:#6b7280;font-weight:600;margin-top:0.1rem;">votos propios</div>
                        @if($ventaja > 0)
                            <div style="font-size:0.75rem;color:#16a34a;font-weight:700;margin-top:0.3rem;">+{{ number_format($ventaja) }} ventaja</div>
                        @elseif($ventaja < 0)
                            <div style="font-size:0.75rem;color:#dc2626;font-weight:700;margin-top:0.3rem;">{{ number_format($ventaja) }} desventaja</div>
                        @else
                            <div style="font-size:0.75rem;color:#9ca3af;margin-top:0.3rem;">Sin datos aún</div>
                        @endif
                    </div>

                    {{-- Progreso mesas --}}
                    <div style="flex:1;min-width:130px;">
                        <div style="font-size:0.7rem;color:#6b7280;font-weight:600;display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                            <span>Mesas reportadas</span>
                            <span style="color:#1f2937;">{{ $mesasReportadas }}/{{ $mesasCubiertas }}</span>
                        </div>
                        <div class="prog-track">
                            <div class="prog-fill" style="width:{{ $pctMesas }}%;background:{{ $elecColor }};"></div>
                        </div>
                        <div style="font-size:0.68rem;color:#9ca3af;margin-top:0.2rem;text-align:right;">{{ $pctMesas }}%</div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Tarjeta de resumen global si hay más de una elección --}}
            @if($elecciones->count() > 1)
            <div class="d-card" style="padding:1.25rem 1.4rem;border-top:4px solid #667eea;display:flex;flex-direction:column;justify-content:center;gap:0.5rem;">
                <div style="font-size:0.7rem;text-transform:uppercase;font-weight:700;color:#9ca3af;letter-spacing:0.5px;margin-bottom:0.25rem;">Resumen Global</div>
                <div style="display:flex;gap:1.5rem;flex-wrap:wrap;">
                    <div>
                        <div style="font-size:1.6rem;font-weight:800;color:#1f2937;line-height:1;">{{ number_format($totalVotosReportados) }}</div>
                        <div style="font-size:0.7rem;color:#9ca3af;font-weight:600;">total votos propios</div>
                    </div>
                    <div>
                        <div style="font-size:1.6rem;font-weight:800;color:#6b7280;line-height:1;">{{ number_format($totalVotosCompetencia) }}</div>
                        <div style="font-size:0.7rem;color:#9ca3af;font-weight:600;">competencia</div>
                    </div>
                </div>
                <div style="font-size:0.75rem;color:#6b7280;margin-top:0.25rem;">{{ $totalReportes }} reportes registrados</div>
            </div>
            @endif
        </div>

        {{-- ═══════════════════════════════════════
             STATS BAR: 4 contadores
        ═══════════════════════════════════════ --}}
        <div class="stats-bar" style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.1rem;">
            @php
            $statsBar = [
                ['lbl'=>'Testigos',      'val'=>$totalTestigos,      'color'=>'#3b82f6',
                 'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['lbl'=>'Coordinadores', 'val'=>$totalCoordinadores, 'color'=>'#8b5cf6',
                 'icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['lbl'=>'Puestos',       'val'=>$totalPuestos,       'color'=>'#10b981',
                 'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['lbl'=>'Total Mesas',   'val'=>$totalMesas,         'color'=>'#f59e0b',
                 'icon'=>'M3 10h18M3 14h18M10 3v18M14 3v18'],
            ];
            @endphp
            @foreach($statsBar as $s)
            <div class="d-card d-card-hover" style="padding:1rem 1.2rem;display:flex;align-items:center;gap:0.85rem;">
                <div style="width:38px;height:38px;border-radius:10px;background:{{ $s['color'] }}1a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="18" height="18" fill="none" stroke="{{ $s['color'] }}" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:1.55rem;font-weight:800;color:#1f2937;line-height:1;">{{ number_format($s['val']) }}</div>
                    <div style="font-size:0.7rem;color:#9ca3af;text-transform:uppercase;letter-spacing:0.4px;font-weight:600;margin-top:0.15rem;">{{ $s['lbl'] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ═══════════════════════════════════════
             DOS COLUMNAS: Reportes | Lateral
        ═══════════════════════════════════════ --}}
        <div class="dash-cols" style="display:grid;grid-template-columns:1fr 300px;gap:1.1rem;align-items:start;">

            {{-- ─── Columna izquierda: Últimos Reportes ─── --}}
            <div class="d-card" style="padding:1.25rem;">
                <h3 style="font-size:0.85rem;font-weight:700;color:#1f2937;margin:0 0 1rem 0;display:flex;align-items:center;gap:0.5rem;">
                    <svg width="16" height="16" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Últimos Reportes
                    <span style="background:#f3f4f6;color:#6b7280;font-size:0.7rem;padding:0.15rem 0.5rem;border-radius:6px;font-weight:600;margin-left:0.25rem;">{{ $ultimosReportes->count() }}</span>
                </h3>

                @if($ultimosReportesPorEleccion->isEmpty())
                <div style="text-align:center;padding:2.5rem 1rem;color:#9ca3af;">
                    <svg width="36" height="36" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" stroke-width="1.5" style="margin:0 auto 0.75rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <div style="font-size:0.85rem;">Sin reportes aún</div>
                </div>
                @else
                @foreach($ultimosReportesPorEleccion as $elec)
                @php $elecColor = $elec->color ?? '#667eea'; @endphp
                <div style="margin-bottom:1.1rem;">
                    {{-- Divisor de elección --}}
                    <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;">
                        <span style="width:8px;height:8px;border-radius:50%;background:{{ $elecColor }};display:inline-block;flex-shrink:0;"></span>
                        <span style="font-size:0.71rem;text-transform:uppercase;font-weight:700;color:{{ $elecColor }};letter-spacing:0.5px;">{{ $elec->nombre }}</span>
                        <div style="flex:1;height:1px;background:#f3f4f6;"></div>
                    </div>

                    @foreach($elec->ultimosReportes as $r)
                    <div class="report-row">
                        {{-- Número de mesa --}}
                        <div style="width:30px;height:30px;border-radius:8px;background:#f8fafc;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.7rem;font-weight:800;color:#6b7280;">
                            {{ $r->mesa->numero_mesa ?? '?' }}
                        </div>

                        {{-- Puesto y testigo --}}
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:0.83rem;font-weight:600;color:#1f2937;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $r->mesa?->puesto?->nombre ?? '—' }}
                            </div>
                            <div style="font-size:0.7rem;color:#9ca3af;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $r->testigo?->nombre ?? $r->mesa?->testigo?->nombre ?? 'Sin testigo' }}
                                · {{ $r->updated_at->diffForHumans() }}
                            </div>
                        </div>

                        {{-- Votos --}}
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-size:0.9rem;font-weight:800;color:#1f2937;">{{ number_format($r->total_votos ?? 0) }}</div>
                            <div style="font-size:0.66rem;color:#9ca3af;">votos</div>
                        </div>

                        {{-- Indicador foto --}}
                        @if($r->imagen_acta)
                        <svg width="13" height="13" fill="none" stroke="#10b981" viewBox="0 0 24 24" stroke-width="2.5" style="flex-shrink:0;" title="Con foto de acta">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endforeach
                @endif
            </div>

            {{-- ─── Columna derecha: Accesos + Cobertura ─── --}}
            <div style="display:flex;flex-direction:column;gap:1rem;">

                {{-- Accesos rápidos --}}
                <div class="d-card" style="padding:1rem;">
                    <div style="font-size:0.7rem;text-transform:uppercase;font-weight:700;color:#9ca3af;letter-spacing:0.4px;margin-bottom:0.5rem;padding:0 0.125rem;">
                        Accesos Rápidos
                    </div>
                    <nav style="display:flex;flex-direction:column;gap:0.1rem;">
                        @php
                        $qLinks = [
                            ['label'=>'Testigos',       'route'=>'testigos.index',      'color'=>'#3b82f6',
                             'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['label'=>'Coordinadores',  'route'=>'coordinadores.index', 'color'=>'#8b5cf6',
                             'icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ['label'=>'Resultados',     'route'=>'resultados.index',    'color'=>'#10b981',
                             'icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['label'=>'Municipios',     'route'=>'municipios.index',    'color'=>'#ef4444',
                             'icon'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                            ['label'=>'Actas',          'route'=>'actas.index',         'color'=>'#f59e0b',
                             'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                            ['label'=>'Elecciones',     'route'=>'elecciones.index',    'color'=>'#6366f1',
                             'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ];
                        @endphp
                        @foreach($qLinks as $lnk)
                        <a href="{{ route($lnk['route']) }}" class="q-link">
                            <div style="width:28px;height:28px;border-radius:7px;background:{{ $lnk['color'] }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="14" height="14" fill="none" stroke="{{ $lnk['color'] }}" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $lnk['icon'] }}"/>
                                </svg>
                            </div>
                            {{ $lnk['label'] }}
                        </a>
                        @endforeach
                    </nav>
                </div>

                {{-- Cobertura de Mesas --}}
                <div class="d-card" style="padding:1.1rem 1.25rem;">
                    <div style="font-size:0.7rem;text-transform:uppercase;font-weight:700;color:#9ca3af;letter-spacing:0.4px;margin-bottom:0.875rem;">
                        Cobertura de Mesas
                    </div>
                    @php
                        $pctAsig = $totalMesas > 0 ? round($mesasCubiertas / $totalMesas * 100) : 0;
                        $pctRep  = $mesasCubiertas > 0 ? round($mesasReportadas / $mesasCubiertas * 100) : 0;
                    @endphp

                    {{-- Asignadas --}}
                    <div style="margin-bottom:0.875rem;">
                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.3rem;">
                            <span>Asignadas a testigos</span>
                            <span>{{ $mesasCubiertas }}/{{ $totalMesas }}</span>
                        </div>
                        <div class="prog-track">
                            <div class="prog-fill" style="width:{{ $pctAsig }}%;background:#3b82f6;"></div>
                        </div>
                        <div style="font-size:0.67rem;color:#9ca3af;margin-top:0.2rem;text-align:right;">{{ $pctAsig }}% asignado</div>
                    </div>

                    {{-- Reportadas --}}
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.3rem;">
                            <span>Con reporte de votos</span>
                            <span>{{ $mesasReportadas }}/{{ $mesasCubiertas }}</span>
                        </div>
                        <div class="prog-track">
                            <div class="prog-fill" style="width:{{ $pctRep }}%;background:#10b981;"></div>
                        </div>
                        <div style="font-size:0.67rem;color:#9ca3af;margin-top:0.2rem;text-align:right;">{{ $pctRep }}% reportado</div>
                    </div>

                    {{-- Mini contadores --}}
                    <div style="margin-top:1rem;padding-top:0.875rem;border-top:1px solid #f3f4f6;display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;text-align:center;">
                        <div style="padding:0.5rem;background:#fef3c7;border-radius:8px;">
                            <div style="font-size:1.3rem;font-weight:800;color:#d97706;">{{ $totalMesasPendientes }}</div>
                            <div style="font-size:0.65rem;color:#92400e;font-weight:700;text-transform:uppercase;">Pendientes</div>
                        </div>
                        <div style="padding:0.5rem;background:#dcfce7;border-radius:8px;">
                            <div style="font-size:1.3rem;font-weight:800;color:#16a34a;">{{ $mesasReportadas }}</div>
                            <div style="font-size:0.65rem;color:#166534;font-weight:700;text-transform:uppercase;">Reportadas</div>
                        </div>
                    </div>
                </div>

            </div>{{-- fin col derecha --}}
        </div>{{-- fin dos columnas --}}

    </div>
    </div>
</x-app-layout>
