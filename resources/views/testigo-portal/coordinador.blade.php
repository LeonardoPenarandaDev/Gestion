<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    Portal Coordinador
                </h2>
                <p style="color: rgba(255,255,255,0.9); margin-top: 0.5rem; font-size: 0.9rem;">
                    Bienvenido, {{ auth()->user()->name }} — Puede reportar cualquier mesa
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif !important; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important; min-height: 100vh; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem; }

        .stat-card { border-radius: 16px; padding: 1.25rem 1.5rem; box-shadow: 0 8px 20px rgba(0,0,0,0.08); color: white; }

        .testigo-group { background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 1.25rem; overflow: hidden; border: 1px solid #e5e7eb; }

        .testigo-header { padding: 1rem 1.5rem; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #e5e7eb; }

        .testigo-body { padding: 1rem 1.5rem; }

        .mesa-row { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 0.5rem; border: 2px solid transparent; transition: all 0.2s; }

        .mesa-row.reportada { background: #f0fdf4; border-color: #86efac; }
        .mesa-row.pendiente { background: #fffbeb; border-color: #fcd34d; }
        .mesa-row.bloqueada { background: #fff7ed; border-color: #fdba74; }

        .btn-reportar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; transition: all 0.2s; box-shadow: 0 3px 10px rgba(102,126,234,0.3); }
        .btn-reportar:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(102,126,234,0.4); color: white; }

        .btn-ver { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; transition: all 0.2s; }
        .btn-ver:hover { transform: translateY(-1px); color: white; }

        .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .badge-ok    { background: #dcfce7; color: #166534; }
        .badge-pend  { background: #fef3c7; color: #92400e; }
        .badge-lock  { background: #ffedd5; color: #9a3412; }
    </style>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                    <strong>✓</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: linear-gradient(135deg, #f56565, #c53030); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                    <strong>✗</strong> {{ session('error') }}
                </div>
            @endif

            {{-- Stats globales --}}
            <div class="stats-grid">
                <div class="stat-card" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; opacity: 0.8;">Total Mesas</div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin: 0.25rem 0;">{{ $totalMesas }}</div>
                    <div style="font-size: 0.8rem; opacity: 0.8;">En todos los testigos</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; opacity: 0.8;">Reportadas</div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin: 0.25rem 0;">{{ $mesasReportadas }}</div>
                    <div style="font-size: 0.8rem; opacity: 0.8;">{{ $totalMesas > 0 ? round(($mesasReportadas/$totalMesas)*100) : 0 }}% completadas</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; opacity: 0.8;">Pendientes</div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin: 0.25rem 0;">{{ $mesasPendientes }}</div>
                    <div style="font-size: 0.8rem; opacity: 0.8;">Por reportar</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; opacity: 0.8;">Testigos</div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin: 0.25rem 0;">{{ $testigos->count() }}</div>
                    <div style="font-size: 0.8rem; opacity: 0.8;">Asignados</div>
                </div>
            </div>

            {{-- Lista de testigos con sus mesas --}}
            @forelse($testigos as $testigo)
            @php
                $mesasTestigo      = $testigo->mesas->sortBy('numero_mesa');
                $reportadasTestigo = $mesasTestigo->filter(fn($m) => $m->resultado)->count();
                $totalTestigo      = $mesasTestigo->count();
                $pctTestigo        = $totalTestigo > 0 ? round(($reportadasTestigo / $totalTestigo) * 100) : 0;
            @endphp
            <div class="testigo-group">
                <div class="testigo-header" onclick="toggleTestigo('t{{ $testigo->id }}')">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; flex-shrink: 0;">
                            {{ strtoupper(substr($testigo->nombre, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1f2937; font-size: 0.95rem;">{{ $testigo->nombre }}</div>
                            <div style="font-size: 0.75rem; color: #6b7280;">
                                Zona {{ $testigo->fk_id_zona }}
                                @if($testigo->puesto) · {{ $testigo->puesto->nombre }} @endif
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        {{-- Barra de progreso --}}
                        <div style="text-align: right; min-width: 120px;">
                            <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">
                                {{ $reportadasTestigo }}/{{ $totalTestigo }} mesas
                            </div>
                            <div style="height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden; width: 100px;">
                                <div style="height: 100%; background: {{ $pctTestigo == 100 ? 'linear-gradient(90deg,#10b981,#059669)' : 'linear-gradient(90deg,#f59e0b,#d97706)' }}; width: {{ $pctTestigo }}%;"></div>
                            </div>
                        </div>
                        <span style="font-weight: 700; font-size: 0.85rem; color: {{ $pctTestigo == 100 ? '#059669' : '#d97706' }};">{{ $pctTestigo }}%</span>
                        <svg id="arrow-t{{ $testigo->id }}" style="width: 1.25rem; height: 1.25rem; color: #9ca3af; transition: transform 0.2s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <div id="t{{ $testigo->id }}" style="display: none;">
                    <div class="testigo-body">
                        @forelse($mesasTestigo as $mesa)
                        @php
                            $bloqueada  = $mesa->resultado && $mesa->resultado->bloqueada;
                            $reportada  = $mesa->resultado && !$bloqueada;
                            $estadoClass = $bloqueada ? 'bloqueada' : ($mesa->resultado ? 'reportada' : 'pendiente');
                        @endphp
                        <div class="mesa-row {{ $estadoClass }}">
                            <div>
                                <span style="font-weight: 700; color: #1f2937;">Mesa #{{ $mesa->numero_mesa }}</span>
                                <span style="margin-left: 0.75rem;">
                                    @if($bloqueada)
                                        <span class="badge badge-lock">🔒 Bloqueada</span>
                                    @elseif($mesa->resultado)
                                        <span class="badge badge-ok">✓ Reportada</span>
                                    @else
                                        <span class="badge badge-pend">⚠ Pendiente</span>
                                    @endif
                                </span>
                                <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.2rem;">
                                    {{ $mesa->puesto->nombre ?? '' }}
                                    @if($mesa->resultado)
                                        · Enviado {{ $mesa->resultado->updated_at->format('d/m H:i') }}
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($bloqueada)
                                    <span style="font-size: 0.8rem; color: #9a3412; font-weight: 600;">Bloqueada</span>
                                @elseif($mesa->resultado)
                                    <a href="{{ route('testigo.reportar', $mesa->id) }}" class="btn-ver">
                                        <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Ver/Editar
                                    </a>
                                @else
                                    <a href="{{ route('testigo.reportar', $mesa->id) }}" class="btn-reportar">
                                        <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Reportar
                                    </a>
                                @endif
                            </div>
                        </div>
                        @empty
                            <p style="color: #9ca3af; font-size: 0.875rem; padding: 0.5rem 0;">Sin mesas asignadas</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @empty
                <div style="text-align: center; padding: 3rem; color: #6b7280; background: white; border-radius: 16px;">
                    No hay testigos registrados.
                </div>
            @endforelse

        </div>
    </div>

    <script>
        function toggleTestigo(id) {
            const body  = document.getElementById(id);
            const arrow = document.getElementById('arrow-' + id);
            const open  = body.style.display !== 'none';
            body.style.display  = open ? 'none' : 'block';
            arrow.style.transform = open ? '' : 'rotate(180deg)';
        }

        // Auto-abrir testigos con mesas pendientes
        document.addEventListener('DOMContentLoaded', function () {
            @foreach($testigos as $testigo)
            @if($testigo->mesas->filter(fn($m) => !$m->resultado)->count() > 0)
            toggleTestigo('t{{ $testigo->id }}');
            @endif
            @endforeach
        });
    </script>
</x-app-layout>
