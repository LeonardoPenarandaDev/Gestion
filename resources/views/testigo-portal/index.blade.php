<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    Portal del Testigo Electoral
                </h2>
                <p style="color: rgba(255,255,255,0.9); margin-top: 0.5rem; font-size: 0.9rem;">
                    Bienvenido, {{ $testigo->nombre }}
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif !important;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;
            min-height: 100vh;
        }

        .modern-container {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.6) 100%);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .stat-card.success {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        }

        .stat-card.warning {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0.5rem 0;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #4a5568;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mesa-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .mesa-card:hover {
            border-color: #4facfe;
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.2);
        }

        .mesa-card.reportada {
            border-color: #48bb78;
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.05) 0%, rgba(72, 187, 120, 0.02) 100%);
        }

        .mesa-card.pendiente {
            border-color: #ed8936;
        }

        .btn-reportar {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        .btn-reportar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
            color: white;
        }

        .btn-ver {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        }

        .btn-ver:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
            color: white;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: #c6f6d5;
            color: #22543d;
        }

        .badge-warning {
            background: #fed7d7;
            color: #742a2a;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);">
                    <strong>✓</strong> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: linear-gradient(135deg, #f56565 0%, #c53030 100%); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);">
                    <strong>✗</strong> {{ session('error') }}
                </div>
            @endif

            {{-- Elecciones activas --}}
            @if($elecciones->isNotEmpty())
            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                    Elecciones del día
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
                    @foreach($elecciones as $eleccion)
                    @php
                        $propios = $eleccion->candidatos->where('tipo','propio')->values();
                        $competencia = $eleccion->candidatos->where('tipo','competencia')->values();
                    @endphp
                    <div style="background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.06);">
                        <div style="background: {{ $eleccion->color }}; padding: 0.75rem 1.25rem; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="color: white; font-weight: 700; font-size: 0.95rem;">{{ $eleccion->nombre }}</div>
                                @if($eleccion->fecha)
                                    <div style="color: rgba(255,255,255,0.8); font-size: 0.75rem;">
                                        {{ \Carbon\Carbon::parse($eleccion->fecha)->format('d/m/Y') }}
                                    </div>
                                @endif
                            </div>
                            <span style="background: rgba(255,255,255,0.2); color: white; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 8px; text-transform: uppercase;">
                                {{ $eleccion->tipo_cargo }}
                            </span>
                        </div>
                        <div style="padding: 1rem 1.25rem;">
                            @if($propios->isNotEmpty())
                            <div style="margin-bottom: 0.75rem;">
                                <div style="font-size: 0.7rem; font-weight: 700; color: #15803d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem;">
                                    Nuestro(s) candidato(s)
                                </div>
                                @foreach($propios as $c)
                                <div style="display: flex; align-items: center; gap: 0.5rem; background: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; padding: 0.4rem 0.75rem; margin-bottom: 0.3rem;">
                                    <svg style="width:0.9rem;height:0.9rem;color:#16a34a;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                                    <span style="font-weight: 600; color: #166534; font-size: 0.85rem;">{{ $c->nombre }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @if($competencia->isNotEmpty())
                            <div>
                                <div style="font-size: 0.7rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem;">
                                    Competencia ({{ $competencia->count() }} candidatos)
                                </div>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.3rem;">
                                    @foreach($competencia->take(6) as $c)
                                    <span style="background: #f3f4f6; color: #4b5563; font-size: 0.7rem; padding: 0.15rem 0.5rem; border-radius: 6px; font-weight: 500;">{{ $c->nombre }}</span>
                                    @endforeach
                                    @if($competencia->count() > 6)
                                    <span style="background: #f3f4f6; color: #9ca3af; font-size: 0.7rem; padding: 0.15rem 0.5rem; border-radius: 6px;">+{{ $competencia->count() - 6 }} más</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total de Mesas</div>
                    <div class="stat-value">{{ $mesas->count() }}</div>
                    <p style="color: #718096; font-size: 0.875rem; margin: 0;">Asignadas a usted</p>
                </div>

                <div class="stat-card success">
                    <div class="stat-label">Mesas Reportadas</div>
                    <div class="stat-value">{{ $mesasReportadas }}</div>
                    <p style="color: #2d3748; font-size: 0.875rem; margin: 0;">Completadas</p>
                </div>

                <div class="stat-card warning">
                    <div class="stat-label">Mesas Pendientes</div>
                    <div class="stat-value">{{ $mesasPendientes }}</div>
                    <p style="color: #2d3748; font-size: 0.875rem; margin: 0;">Por reportar</p>
                </div>
            </div>

            <div class="modern-container">
                <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #2d3748; margin: 0;">
                        Mis Mesas Asignadas
                    </h3>
                    <p style="color: #718096; margin-top: 0.5rem; margin-bottom: 0;">
                        Puesto: <strong>{{ $testigo->puesto->nombre }}</strong> (Zona {{ $testigo->fk_id_zona }})
                    </p>
                </div>

                <div style="padding: 2rem;">
                    @forelse($mesas as $mesa)
                    @php
                        $resultadosPorEleccion = $mesa->resultados->keyBy('eleccion_id');
                        $todasBloqueadas = $elecciones->isNotEmpty() && $elecciones->every(
                            fn($e) => isset($resultadosPorEleccion[$e->id]) && $resultadosPorEleccion[$e->id]->bloqueada
                        );
                        $algunaReportada = $resultadosPorEleccion->isNotEmpty();
                    @endphp
                        <div class="mesa-card {{ $todasBloqueadas ? 'reportada' : ($algunaReportada ? 'reportada' : 'pendiente') }}">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                        <h4 style="font-size: 1.25rem; font-weight: 700; color: #2d3748; margin: 0;">
                                            Mesa #{{ $mesa->numero_mesa }}
                                        </h4>
                                        @if($todasBloqueadas)
                                            <span class="badge badge-success" style="background:linear-gradient(135deg,#f97316,#ea580c);">🔒 Completa</span>
                                        @elseif($algunaReportada)
                                            <span class="badge badge-success">⚡ En progreso</span>
                                        @else
                                            <span class="badge badge-warning">⚠ Pendiente</span>
                                        @endif
                                    </div>
                                    <p style="color: #718096; margin: 0 0 0.75rem 0;">{{ $mesa->puesto->nombre }}</p>

                                    {{-- Botones por elección --}}
                                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                                        @foreach($elecciones as $elec)
                                        @php
                                            $res = $resultadosPorEleccion[$elec->id] ?? null;
                                            $locked = $res && $res->bloqueada;
                                        @endphp
                                        @if($locked)
                                            <span style="display:inline-flex;align-items:center;gap:0.3rem;background:#f0fdf4;color:#166534;border:1px solid #86efac;padding:0.35rem 0.75rem;border-radius:7px;font-size:0.78rem;font-weight:600;">
                                                🔒 {{ $elec->nombre }}
                                            </span>
                                        @elseif($res)
                                            <a href="{{ route('testigo.reportar', [$mesa->id, $elec->id]) }}"
                                               style="display:inline-flex;align-items:center;gap:0.3rem;background:linear-gradient(135deg,#48bb78,#38a169);color:white;padding:0.35rem 0.75rem;border-radius:7px;font-size:0.78rem;font-weight:600;text-decoration:none;">
                                                ✎ {{ $elec->nombre }}
                                            </a>
                                        @else
                                            <a href="{{ route('testigo.reportar', [$mesa->id, $elec->id]) }}"
                                               style="display:inline-flex;align-items:center;gap:0.3rem;background:{{ $elec->color }};color:white;padding:0.35rem 0.75rem;border-radius:7px;font-size:0.78rem;font-weight:600;text-decoration:none;">
                                                + {{ $elec->nombre }}
                                            </a>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 3rem; color: #718096;">
                            <svg style="width: 4rem; height: 4rem; margin: 0 auto 1rem; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p style="font-size: 1.125rem; margin: 0;">No tiene mesas asignadas</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
