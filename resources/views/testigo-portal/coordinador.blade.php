<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">Portal Coordinador</h2>
                <p style="color: rgba(255,255,255,0.9); margin-top: 0.5rem; font-size: 0.9rem;">
                    {{ auth()->user()->name }}
                    @if($puesto)
                        — {{ $puesto->nombre }} (Zona {{ $puesto->zona }}, Puesto {{ $puesto->puesto }})
                    @endif
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        body { font-family: 'Inter', sans-serif !important; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important; min-height: 100vh; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem; }
        .stat-card { border-radius: 16px; padding: 1.25rem 1.5rem; box-shadow: 0 8px 20px rgba(0,0,0,0.08); color: white; }
        .mesa-row { display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 0.5rem; border: 2px solid transparent; transition: all 0.2s; }
        .mesa-row.reportada { background: #f0fdf4; border-color: #86efac; }
        .mesa-row.pendiente  { background: #fffbeb; border-color: #fcd34d; }
        .mesa-row.bloqueada  { background: #fff7ed; border-color: #fdba74; }
        .btn-reportar { background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; transition: all 0.2s; box-shadow: 0 3px 10px rgba(102,126,234,0.3); }
        .btn-reportar:hover { transform: translateY(-1px); color: white; }
        .btn-ver { background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; transition: all 0.2s; }
        .btn-ver:hover { transform: translateY(-1px); color: white; }
        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .badge-ok   { background: #dcfce7; color: #166534; }
        .badge-pend { background: #fef3c7; color: #92400e; }
        .badge-lock { background: #ffedd5; color: #9a3412; }
        .badge-sin  { background: #f1f5f9; color: #64748b; }
    </style>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div style="background: linear-gradient(135deg,#48bb78,#38a169); color:white; padding:1rem; border-radius:12px; margin-bottom:1.5rem;">
                    <strong>✓</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: linear-gradient(135deg,#f56565,#c53030); color:white; padding:1rem; border-radius:12px; margin-bottom:1.5rem;">
                    <strong>✗</strong> {{ session('error') }}
                </div>
            @endif

            @if(!$puesto)
                <div style="background:white; border-radius:16px; padding:3rem; text-align:center; color:#6b7280; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    <svg width="48" height="48" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" stroke-width="1.5" style="margin: 0 auto 1rem; display:block;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
                    </svg>
                    <p style="font-size:1.1rem; font-weight:600; color:#374151;">Sin puesto asignado</p>
                    <p style="margin-top:0.5rem;">Solicita al administrador que te asigne un puesto de votación.</p>
                </div>
            @else

            {{-- Stats --}}
            <div class="stats-grid">
                <div class="stat-card" style="background: linear-gradient(135deg,#667eea,#764ba2);">
                    <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; opacity:0.8;">Total Mesas</div>
                    <div style="font-size:2.5rem; font-weight:700; margin:0.25rem 0;">{{ $totalMesas }}</div>
                    <div style="font-size:0.8rem; opacity:0.8;">En tu puesto</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg,#10b981,#059669);">
                    <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; opacity:0.8;">Reportadas</div>
                    <div style="font-size:2.5rem; font-weight:700; margin:0.25rem 0;">{{ $mesasReportadas }}</div>
                    <div style="font-size:0.8rem; opacity:0.8;">{{ $totalMesas > 0 ? round(($mesasReportadas/$totalMesas)*100) : 0 }}% completadas</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#d97706);">
                    <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; opacity:0.8;">Pendientes</div>
                    <div style="font-size:2.5rem; font-weight:700; margin:0.25rem 0;">{{ $mesasPendientes }}</div>
                    <div style="font-size:0.8rem; opacity:0.8;">Por reportar</div>
                </div>
            </div>

            {{-- Elecciones activas + votos en el puesto --}}
            @if($elecciones->isNotEmpty())
            <div style="margin-bottom:1.5rem;">
                <h3 style="font-size:0.85rem; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.75rem;">
                    Elecciones activas — Votos acumulados en tu puesto
                </h3>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(270px,1fr)); gap:1rem;">
                    @foreach($elecciones as $eleccion)
                    @php
                        $propios = $eleccion->candidatos->where('tipo','propio')->values();
                        $competencia = $eleccion->candidatos->where('tipo','competencia')->values();
                        // Sumar votos del puesto por candidato de esta eleccion
                        $votosPropioTotal = 0;
                        $votosCompTotal = 0;
                        foreach($eleccion->candidatos as $cand) {
                            $suma = isset($votosPuesto[$cand->id]) ? $votosPuesto[$cand->id]->sum('votos') : 0;
                            if($cand->tipo === 'propio') $votosPropioTotal += $suma;
                            else $votosCompTotal += $suma;
                        }
                        $totalVotos = $votosPropioTotal + $votosCompTotal;
                        $pct = $totalVotos > 0 ? round(($votosPropioTotal / $totalVotos) * 100) : 0;
                    @endphp
                    <div style="background:white; border-radius:14px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.08); border:1px solid rgba(0,0,0,0.06);">
                        <div style="background:{{ $eleccion->color }}; padding:0.65rem 1rem; display:flex; align-items:center; justify-content:space-between;">
                            <div style="color:white; font-weight:700; font-size:0.9rem;">{{ $eleccion->nombre }}</div>
                            <span style="background:rgba(255,255,255,0.2); color:white; font-size:0.65rem; font-weight:700; padding:0.15rem 0.5rem; border-radius:6px; text-transform:uppercase;">{{ $eleccion->tipo_cargo }}</span>
                        </div>
                        <div style="padding:0.85rem 1rem;">
                            @if($mesasReportadas > 0 && $totalVotos > 0)
                            {{-- Barra de progreso de votos --}}
                            <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:600; margin-bottom:0.3rem;">
                                <span style="color:#16a34a;">Nuestros: {{ number_format($votosPropioTotal) }}</span>
                                <span style="color:#dc2626;">Competencia: {{ number_format($votosCompTotal) }}</span>
                            </div>
                            <div style="background:#f3f4f6; border-radius:6px; height:8px; overflow:hidden; margin-bottom:0.5rem;">
                                <div style="background:linear-gradient(90deg,#16a34a,#22c55e); height:100%; width:{{ $pct }}%; transition:width 0.5s;"></div>
                            </div>
                            <div style="font-size:0.7rem; color:#6b7280; text-align:center;">
                                {{ $pct }}% a nuestro favor · {{ $totalVotos }} votos totales
                            </div>
                            @else
                            {{-- Sin reportes aún --}}
                            <div style="text-align:center; padding:0.5rem 0;">
                                @if($propios->isNotEmpty())
                                <div style="font-size:0.75rem; font-weight:600; color:#166534; margin-bottom:0.3rem;">
                                    @foreach($propios as $c) {{ $c->nombre }}@if(!$loop->last), @endif @endforeach
                                </div>
                                @endif
                                <div style="font-size:0.7rem; color:#9ca3af;">Sin reportes aún en este puesto</div>
                            </div>
                            @endif
                            {{-- Lista candidatos propios siempre visible --}}
                            @if($propios->isNotEmpty() && ($mesasReportadas > 0 && $totalVotos > 0))
                            <div style="margin-top:0.5rem; padding-top:0.5rem; border-top:1px solid #f3f4f6;">
                                @foreach($propios as $c)
                                @php $cv = isset($votosPuesto[$c->id]) ? $votosPuesto[$c->id]->sum('votos') : 0; @endphp
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; padding:0.15rem 0;">
                                    <span style="color:#166534; font-weight:600;">{{ $c->nombre }}</span>
                                    <span style="color:#374151; font-weight:700;">{{ number_format($cv) }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Info del puesto --}}
            <div style="background:white; border-radius:12px; padding:1rem 1.5rem; margin-bottom:1.5rem; display:flex; align-items:center; gap:1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <div style="width:40px; height:40px; border-radius:10px; background: linear-gradient(135deg,#667eea,#764ba2); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <div style="font-weight:700; color:#1f2937;">{{ $puesto->nombre }}</div>
                    <div style="font-size:0.8rem; color:#6b7280;">{{ $puesto->direccion }} · Zona {{ $puesto->zona }}, Puesto {{ $puesto->puesto }}</div>
                </div>
            </div>

            {{-- Lista de todas las mesas del puesto --}}
            <div style="background:white; border-radius:16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow:hidden; border:1px solid #e5e7eb;">
                <div style="padding:1rem 1.5rem; background: linear-gradient(135deg,#f8fafc,#f1f5f9); border-bottom:1px solid #e5e7eb;">
                    <span style="font-weight:700; color:#1f2937; font-size:0.95rem;">Todas las mesas del puesto</span>
                    <span style="font-size:0.8rem; color:#6b7280; margin-left:0.5rem;">— Como coordinador puedes reportar cualquier mesa</span>
                </div>
                <div style="padding:1rem 1.5rem;">
                    @forelse($mesas as $mesa)
                    @php
                        $resPorElec = $mesa->resultados->keyBy('eleccion_id');
                        $todasCompletas = $elecciones->isNotEmpty() && $elecciones->every(
                            fn($e) => isset($resPorElec[$e->id]) && $resPorElec[$e->id]->bloqueada
                        );
                        $algunaReportada = $resPorElec->isNotEmpty();
                        $estadoClass = $todasCompletas ? 'bloqueada' : ($algunaReportada ? 'reportada' : 'pendiente');
                        // Votos totales (suma de todos los resultados de la mesa)
                        $mesaVotosPropio = $mesa->resultados->sum('total_votos');
                        $mesaVotosComp   = $mesa->resultados->sum('votos_competencia');
                    @endphp
                    <div class="mesa-row {{ $estadoClass }}">
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; margin-bottom:0.4rem;">
                                <span style="font-weight:700; color:#1f2937; font-size:1rem;">Mesa #{{ $mesa->numero_mesa }}</span>
                                @if($todasCompletas)
                                    <span class="badge badge-lock">🔒 Completa</span>
                                @elseif($algunaReportada)
                                    <span class="badge badge-ok">⚡ En progreso</span>
                                @else
                                    <span class="badge badge-pend">⚠ Pendiente</span>
                                @endif
                                @if($mesa->testigo)
                                    <span style="font-size:0.72rem; color:#6b7280;">{{ $mesa->testigo->nombre }}</span>
                                @else
                                    <span class="badge badge-sin">Sin testigo</span>
                                @endif
                                @if($mesaVotosPropio + $mesaVotosComp > 0)
                                    <span style="font-size:0.7rem;background:#dcfce7;color:#166534;padding:0.1rem 0.45rem;border-radius:5px;font-weight:600;">↑{{ number_format($mesaVotosPropio) }}</span>
                                    <span style="font-size:0.7rem;background:#fee2e2;color:#991b1b;padding:0.1rem 0.45rem;border-radius:5px;font-weight:600;">↓{{ number_format($mesaVotosComp) }}</span>
                                @endif
                            </div>
                            {{-- Botones por elección --}}
                            <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                                @foreach($elecciones as $elec)
                                @php $resElec = $resPorElec[$elec->id] ?? null; $lockedElec = $resElec && $resElec->bloqueada; @endphp
                                @if($lockedElec)
                                    <span style="display:inline-flex;align-items:center;gap:0.25rem;background:#f0fdf4;color:#166534;border:1px solid #86efac;padding:0.25rem 0.6rem;border-radius:6px;font-size:0.72rem;font-weight:600;">
                                        🔒 {{ $elec->nombre }}
                                    </span>
                                @elseif($resElec)
                                    <a href="{{ route('testigo.reportar', [$mesa->id, $elec->id]) }}" class="btn-ver" style="padding:0.25rem 0.6rem;font-size:0.72rem;">
                                        ✎ {{ $elec->nombre }}
                                    </a>
                                @else
                                    <a href="{{ route('testigo.reportar', [$mesa->id, $elec->id]) }}" class="btn-reportar" style="padding:0.25rem 0.6rem;font-size:0.72rem;background:{{ $elec->color }};">
                                        + {{ $elec->nombre }}
                                    </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @empty
                        <p style="color:#9ca3af; text-align:center; padding:2rem;">No hay mesas en este puesto.</p>
                    @endforelse
                </div>
            </div>

            @endif
        </div>
    </div>
</x-app-layout>
