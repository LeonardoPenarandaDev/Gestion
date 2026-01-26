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
                        <div class="mesa-card {{ $mesa->resultado ? 'reportada' : 'pendiente' }}">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                        <h4 style="font-size: 1.25rem; font-weight: 700; color: #2d3748; margin: 0;">
                                            Mesa #{{ $mesa->numero_mesa }}
                                        </h4>
                                        @if($mesa->resultado)
                                            <span class="badge badge-success">✓ Reportada</span>
                                        @else
                                            <span class="badge badge-warning">⚠ Pendiente</span>
                                        @endif
                                    </div>
                                    <p style="color: #718096; margin: 0;">
                                        {{ $mesa->puesto->nombre }}
                                    </p>
                                    @if($mesa->resultado)
                                        <p style="color: #48bb78; margin-top: 0.5rem; font-size: 0.875rem; margin-bottom: 0;">
                                            <strong>Reportado:</strong> {{ $mesa->resultado->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    @if($mesa->resultado)
                                        <a href="{{ route('testigo.reportar', $mesa->id) }}" class="btn-ver">
                                            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Ver/Editar
                                        </a>
                                    @else
                                        <a href="{{ route('testigo.reportar', $mesa->id) }}" class="btn-reportar">
                                            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Reportar
                                        </a>
                                    @endif
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
