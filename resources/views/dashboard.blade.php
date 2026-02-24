<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    {{ __('Dashboard Electoral') }}
                </h2>
                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                    Panel de Control Administrativo
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
        
        .modern-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 100%);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .counter {
            font-variant-numeric: tabular-nums;
            font-weight: bold;
            font-size: 2.5rem;
            color: #1f2937;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            margin-bottom: 0.75rem;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.8);
            color: #374151;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            color: #374151;
            text-decoration: none;
        }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .icon-blue { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .icon-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .icon-yellow { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .icon-purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            margin-top: 1rem;
        }
        
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-purple { background: #f3e8ff; color: #7c2d12; }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .management-card {
            padding: 1.25rem !important;
        }

        .management-card .icon-circle {
            width: 40px !important;
            height: 40px !important;
        }

        .management-card h3 {
            font-size: 1rem !important;
        }

        .management-card .btn-gradient,
        .management-card .btn-secondary {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        /* Calendar Styles */
        .calendar-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .calendar-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .calendar-month {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .calendar-nav {
            display: flex;
            gap: 1rem;
        }

        .calendar-nav button {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar-nav button:hover {
            background: rgba(255,255,255,0.4);
        }

        .calendar-grid {
            padding: 1.5rem;
        }

        .weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            color: #6b7280;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }

        .day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
            color: #374151;
        }

        .day:hover:not(.empty) {
            background: #f3f4f6;
        }

        .day.today {
            background: #ebf5ff;
            color: #2563eb;
            font-weight: bold;
        }

        .day.event {
            background: #764ba2;
            color: white;
            box-shadow: 0 4px 6px rgba(118, 75, 162, 0.3);
        }
        
        .day.event-congress {
             background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .event-list {
            padding: 0 1.5rem 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .event-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .event-item:last-child {
            border-bottom: none;
        }

        .event-date {
            font-weight: 700;
            color: #4b5563;
            width: 50px;
            text-align: center;
            line-height: 1.2;
        }
        
        .event-date span {
            display: block;
            font-size: 0.8rem;
            font-weight: 400;
        }

        .event-info {
            margin-left: 1rem;
        }

        .event-title {
            font-weight: 600;
            color: #1f2937;
        }

        .event-desc {
            font-size: 0.85rem;
            color: #6b7280;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div style="padding: 3rem 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">

            <!-- Municipios Estratégicos -->
            @if(isset($municipiosDestacados) && $municipiosDestacados->count() > 0)
            <div class="fade-in" style="margin-bottom: 2rem;">
                <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; padding-left: 0.5rem; border-left: 3px solid #667eea; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Municipios Estratégicos
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                    @foreach($municipiosDestacados as $mun)
                    @php
                        $totalVotosMun = $mun->votos_candidato + $mun->votos_competencia;
                        $pctCandidato = $totalVotosMun > 0 ? round(($mun->votos_candidato / $totalVotosMun) * 100, 1) : 0;
                        $pctCompetencia = $totalVotosMun > 0 ? round(($mun->votos_competencia / $totalVotosMun) * 100, 1) : 0;
                        $difVotos = $mun->votos_candidato - $mun->votos_competencia;
                        $esFavorable = $difVotos >= 0;
                        $pctCobertura = $mun->total_mesas > 0 ? round(($mun->mesas_reportadas / $mun->total_mesas) * 100) : 0;
                    @endphp
                    <div class="modern-card" style="padding: 0; overflow: hidden;">
                        {{-- Header con color del municipio --}}
                        <div style="background: linear-gradient(135deg, {{ $mun->color }} 0%, {{ $mun->color }}dd 100%); padding: 1rem 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                            <h4 style="color: white; font-size: 1rem; font-weight: 700; margin: 0;">{{ $mun->nombre }}</h4>
                            <span style="background: rgba(255,255,255,0.2); color: white; padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                {{ $mun->total_puestos }} puestos
                            </span>
                        </div>

                        <div style="padding: 1.25rem;">
                            {{-- Votos candidato vs competencia --}}
                            <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 0.5rem; align-items: center; margin-bottom: 1rem;">
                                <div style="text-align: center; padding: 0.75rem; background: #f0fdf4; border-radius: 10px;">
                                    <div style="font-size: 1.4rem; font-weight: 700; color: #166534;">{{ number_format($mun->votos_candidato) }}</div>
                                    <div style="font-size: 0.7rem; color: #16a34a; font-weight: 600;">Candidato</div>
                                    <div style="font-size: 0.8rem; font-weight: 700; color: #15803d;">{{ $pctCandidato }}%</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 0.75rem; color: #9ca3af;">VS</div>
                                </div>
                                <div style="text-align: center; padding: 0.75rem; background: #fef2f2; border-radius: 10px;">
                                    <div style="font-size: 1.4rem; font-weight: 700; color: #991b1b;">{{ number_format($mun->votos_competencia) }}</div>
                                    <div style="font-size: 0.7rem; color: #dc2626; font-weight: 600;">Competencia</div>
                                    <div style="font-size: 0.8rem; font-weight: 700; color: #b91c1c;">{{ $pctCompetencia }}%</div>
                                </div>
                            </div>

                            {{-- Barra comparativa --}}
                            <div style="margin-bottom: 1rem;">
                                <div style="height: 8px; background: #fee2e2; border-radius: 4px; overflow: hidden;">
                                    <div style="height: 100%; background: linear-gradient(90deg, #22c55e, #16a34a); width: {{ $pctCandidato }}%; border-radius: 4px;"></div>
                                </div>
                            </div>

                            {{-- Diferencia --}}
                            <div style="text-align: center; padding: 0.5rem; background: {{ $esFavorable ? '#eff6ff' : '#fefce8' }}; border-radius: 8px; margin-bottom: 1rem;">
                                <span style="font-size: 1.1rem; font-weight: 700; color: {{ $esFavorable ? '#1e40af' : '#92400e' }};">
                                    {{ $esFavorable ? '+' : '' }}{{ number_format($difVotos) }}
                                </span>
                                <span style="font-size: 0.75rem; color: {{ $esFavorable ? '#3b82f6' : '#d97706' }}; margin-left: 0.25rem;">
                                    {{ $esFavorable ? 'Ventaja' : 'Desventaja' }}
                                </span>
                            </div>

                            {{-- Mini stats --}}
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; margin-bottom: 0.75rem;">
                                <div style="text-align: center; padding: 0.4rem; background: #f9fafb; border-radius: 8px;">
                                    <div style="font-size: 1rem; font-weight: 700; color: #374151;">{{ $mun->testigos }}</div>
                                    <div style="font-size: 0.65rem; color: #6b7280;">Testigos</div>
                                </div>
                                <div style="text-align: center; padding: 0.4rem; background: #f9fafb; border-radius: 8px;">
                                    <div style="font-size: 1rem; font-weight: 700; color: #374151;">{{ $mun->mesas_reportadas }}</div>
                                    <div style="font-size: 0.65rem; color: #6b7280;">Reportadas</div>
                                </div>
                                <div style="text-align: center; padding: 0.4rem; background: #f9fafb; border-radius: 8px;">
                                    <div style="font-size: 1rem; font-weight: 700; color: #374151;">{{ $mun->total_mesas }}</div>
                                    <div style="font-size: 0.65rem; color: #6b7280;">Total Mesas</div>
                                </div>
                            </div>

                            {{-- Barra de cobertura --}}
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem; font-size: 0.75rem;">
                                    <span style="color: #6b7280;">Cobertura</span>
                                    <span style="font-weight: 600; color: {{ $mun->color }};">{{ $pctCobertura }}%</span>
                                </div>
                                <div style="height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden;">
                                    <div style="height: 100%; background: {{ $mun->color }}; width: {{ $pctCobertura }}%; border-radius: 3px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Panel de Estadísticas con Gráficos -->
            <div class="fade-in" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">

                <!-- Comparativa de Votos: Candidato vs Competencia -->
                <div class="modern-card" style="padding: 1.5rem; grid-column: span 2;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Comparativa de Votos
                    </h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <!-- Nuestro Candidato -->
                        <div style="text-align: center; padding: 1.25rem; background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 12px; border: 2px solid #86efac;">
                            <div id="totalVotosReportados" style="font-size: 2rem; font-weight: 700; color: #166534;">{{ number_format($totalVotosReportados ?? 0) }}</div>
                            <div style="font-size: 0.85rem; color: #16a34a; font-weight: 600;">Nuestro Candidato</div>
                            @php
                                $totalVotos = ($totalVotosReportados ?? 0) + ($totalVotosCompetencia ?? 0);
                                $porcentajeCandidato = $totalVotos > 0 ? round(($totalVotosReportados / $totalVotos) * 100, 1) : 0;
                            @endphp
                            <div style="margin-top: 0.5rem; font-size: 1.1rem; font-weight: 700; color: #15803d;">{{ $porcentajeCandidato }}%</div>
                        </div>

                        <!-- Gráfico Comparativo -->
                        <div style="display: flex; flex-direction: column; justify-content: center; padding: 1rem;">
                            <div style="height: 120px;">
                                <canvas id="chartComparativoVotos"></canvas>
                            </div>
                        </div>

                        <!-- Competencia -->
                        <div style="text-align: center; padding: 1.25rem; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 12px; border: 2px solid #fca5a5;">
                            <div id="totalVotosCompetencia" style="font-size: 2rem; font-weight: 700; color: #991b1b;">{{ number_format($totalVotosCompetencia ?? 0) }}</div>
                            <div style="font-size: 0.85rem; color: #dc2626; font-weight: 600;">Competencia</div>
                            @php
                                $porcentajeCompetencia = $totalVotos > 0 ? round(($totalVotosCompetencia / $totalVotos) * 100, 1) : 0;
                            @endphp
                            <div style="margin-top: 0.5rem; font-size: 1.1rem; font-weight: 700; color: #b91c1c;">{{ $porcentajeCompetencia }}%</div>
                        </div>

                        <!-- Diferencia -->
                        @php
                            $diferencia = ($totalVotosReportados ?? 0) - ($totalVotosCompetencia ?? 0);
                            $esPositivo = $diferencia >= 0;
                        @endphp
                        <div style="text-align: center; padding: 1.25rem; background: {{ $esPositivo ? 'linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%)' : 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)' }}; border-radius: 12px;">
                            <div style="font-size: 2rem; font-weight: 700; color: {{ $esPositivo ? '#1e40af' : '#92400e' }};">
                                {{ $esPositivo ? '+' : '' }}{{ number_format($diferencia) }}
                            </div>
                            <div style="font-size: 0.85rem; color: {{ $esPositivo ? '#3b82f6' : '#d97706' }}; font-weight: 600;">
                                {{ $esPositivo ? 'Ventaja' : 'Desventaja' }}
                            </div>
                        </div>
                    </div>

                    <!-- Barra de progreso comparativa -->
                    <div style="margin-top: 1.25rem; padding: 1rem; background: #f9fafb; border-radius: 8px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.8rem; font-weight: 600;">
                            <span style="color: #16a34a;">Candidato: {{ $porcentajeCandidato }}%</span>
                            <span style="color: #dc2626;">Competencia: {{ $porcentajeCompetencia }}%</span>
                        </div>
                        <div style="height: 12px; background: #fee2e2; border-radius: 6px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #22c55e, #16a34a); width: {{ $porcentajeCandidato }}%; border-radius: 6px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Resumen Rápido -->
                <div class="modern-card" style="padding: 1.5rem;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Resumen General
                    </h3>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                        <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px;">
                            <div style="font-size: 1.8rem; font-weight: 700; color: #1e40af;">{{ number_format($totalPuestos ?? 0) }}</div>
                            <div style="font-size: 0.8rem; color: #3b82f6; font-weight: 500;">Puestos</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px;">
                            <div style="font-size: 1.8rem; font-weight: 700; color: #92400e;">{{ number_format($totalTestigos ?? 0) }}</div>
                            <div style="font-size: 0.8rem; color: #d97706; font-weight: 500;">Testigos</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 12px;">
                            <div id="mesasReportadas" style="font-size: 1.8rem; font-weight: 700; color: #166534;">{{ number_format($mesasReportadas ?? 0) }}</div>
                            <div style="font-size: 0.8rem; color: #16a34a; font-weight: 500;">Mesas Reportadas</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 12px;">
                            <div style="font-size: 1.8rem; font-weight: 700; color: #7c3aed;">{{ number_format($totalMesas ?? 0) }}</div>
                            <div style="font-size: 0.8rem; color: #8b5cf6; font-weight: 500;">Total Mesas</div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Cobertura de Mesas -->
                <div class="modern-card" style="padding: 1.5rem;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#10b981" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cobertura de Mesas
                    </h3>
                    <div style="display: flex; align-items: center; gap: 1.5rem;">
                        <div style="width: 140px; height: 140px;">
                            <canvas id="chartCoberturaMesas"></canvas>
                        </div>
                        <div style="flex: 1;">
                            <div style="margin-bottom: 0.75rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                                    <span style="font-size: 0.85rem; color: #374151;">Cubiertas</span>
                                    <span style="font-size: 0.85rem; font-weight: 600; color: #10b981;">{{ $mesasCubiertas ?? 0 }}</span>
                                </div>
                                <div style="height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                    <div style="height: 100%; background: linear-gradient(90deg, #10b981, #059669); width: {{ $totalMesas > 0 ? round(($mesasCubiertas / $totalMesas) * 100) : 0 }}%;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.75rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                                    <span style="font-size: 0.85rem; color: #374151;">Pendientes</span>
                                    <span style="font-size: 0.85rem; font-weight: 600; color: #f59e0b;">{{ $totalMesasPendientes ?? 0 }}</span>
                                </div>
                                <div style="height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                    <div style="height: 100%; background: linear-gradient(90deg, #f59e0b, #d97706); width: {{ $totalMesas > 0 ? round(($totalMesasPendientes / $totalMesas) * 100) : 0 }}%;"></div>
                                </div>
                            </div>
                            <div style="text-align: center; padding: 0.5rem; background: #f0fdf4; border-radius: 8px; margin-top: 0.5rem;">
                                <span style="font-size: 1.2rem; font-weight: 700; color: #166534;">{{ $totalMesas > 0 ? round(($mesasCubiertas / $totalMesas) * 100) : 0 }}%</span>
                                <span style="font-size: 0.75rem; color: #16a34a; display: block;">Cobertura</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Progreso de Reportes -->
                <div class="modern-card" style="padding: 1.5rem;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#8b5cf6" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Progreso de Reportes E14
                    </h3>
                    <div style="display: flex; align-items: center; gap: 1.5rem;">
                        <div style="width: 140px; height: 140px;">
                            <canvas id="chartProgresoReportes"></canvas>
                        </div>
                        <div style="flex: 1;">
                            <div style="margin-bottom: 0.75rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                                    <span style="font-size: 0.85rem; color: #374151;">Reportadas</span>
                                    <span id="mesasReportadas2" style="font-size: 0.85rem; font-weight: 600; color: #10b981;">{{ $mesasReportadas ?? 0 }}</span>
                                </div>
                                <div style="height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                    <div style="height: 100%; background: linear-gradient(90deg, #10b981, #059669); width: {{ $mesasCubiertas > 0 ? round(($mesasReportadas / $mesasCubiertas) * 100) : 0 }}%;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.75rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                                    <span style="font-size: 0.85rem; color: #374151;">Sin Reportar</span>
                                    <span id="mesasSinReportar" style="font-size: 0.85rem; font-weight: 600; color: #ef4444;">{{ $mesasSinReportar ?? 0 }}</span>
                                </div>
                                <div style="height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                    <div style="height: 100%; background: linear-gradient(90deg, #ef4444, #dc2626); width: {{ $mesasCubiertas > 0 ? round(($mesasSinReportar / $mesasCubiertas) * 100) : 0 }}%;"></div>
                                </div>
                            </div>
                            <div style="text-align: center; padding: 0.5rem; background: #faf5ff; border-radius: 8px; margin-top: 0.5rem;">
                                <span style="font-size: 1.2rem; font-weight: 700; color: #7c3aed;">{{ $mesasCubiertas > 0 ? round(($mesasReportadas / $mesasCubiertas) * 100) : 0 }}%</span>
                                <span style="font-size: 0.75rem; color: #8b5cf6; display: block;">Reportado</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Votos por Municipio -->
                @if(isset($votosPorMunicipio) && $votosPorMunicipio->count() > 0)
                <div class="modern-card" style="padding: 1.5rem; grid-column: span 2;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#3b82f6" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Votos por Municipio
                        <span style="margin-left: auto; font-size: 0.8rem; font-weight: 400; color: #6b7280;">{{ $votosPorMunicipio->count() }} municipios</span>
                    </h3>
                    <div style="height: 300px;">
                        <canvas id="chartVotosMunicipio"></canvas>
                    </div>
                </div>
                @endif

                <!-- Gráfico de Distribución por Zona -->
                @if(isset($puestosPorZona) && $puestosPorZona->count() > 0)
                <div class="modern-card" style="padding: 1.5rem;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#f59e0b" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Puestos por Zona
                    </h3>
                    <div style="height: 200px;">
                        <canvas id="chartPuestosZona"></canvas>
                    </div>
                </div>
                @endif

                <!-- Testigos por Zona -->
                @if(isset($testigosPorZona) && $testigosPorZona->count() > 0)
                <div class="modern-card" style="padding: 1.5rem;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#8b5cf6" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Testigos por Zona
                    </h3>
                    <div style="height: 200px;">
                        <canvas id="chartTestigosZona"></canvas>
                    </div>
                </div>
                @endif

                <!-- Puestos con más Testigos Asignados -->
                @if(isset($puestosConMasTestigos) && $puestosConMasTestigos->count() > 0)
                <div class="modern-card" style="padding: 1.5rem;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#10b981" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Top Puestos con Testigos
                    </h3>
                    <div style="max-height: 200px; overflow-y: auto;">
                        @foreach($puestosConMasTestigos as $puesto)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #f3f4f6;">
                            <div style="flex: 1;">
                                <div style="font-size: 0.85rem; color: #374151; font-weight: 500;">{{ $puesto->nombre }}</div>
                                <div style="font-size: 0.75rem; color: #6b7280;">Zona {{ $puesto->zona }}</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600; font-size: 0.8rem;">
                                    {{ $puesto->testigos_count }} testigos
                                </span>
                                <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem;">
                                    {{ $puesto->total_mesas ?? 0 }} mesas
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Resumen de Asignación de Mesas -->
                <div class="modern-card" style="padding: 1.5rem;">
                    <h3 style="color: #374151; font-size: 1.1rem; font-weight: 600; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="20" height="20" fill="none" stroke="#ef4444" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Estado de Asignaciones
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 12px;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #166534;">{{ $mesasCubiertas ?? 0 }}</div>
                            <div style="font-size: 0.75rem; color: #16a34a; font-weight: 500;">Mesas Asignadas</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 12px;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #991b1b;">{{ $totalMesasPendientes ?? 0 }}</div>
                            <div style="font-size: 0.75rem; color: #dc2626; font-weight: 500;">Mesas Pendientes</div>
                        </div>
                    </div>
                    <div style="margin-top: 1rem; padding: 0.75rem; background: #f9fafb; border-radius: 8px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.8rem;">
                            <span style="color: #374151;">Progreso de asignación</span>
                            <span style="font-weight: 600; color: #166534;">{{ $totalMesas > 0 ? round(($mesasCubiertas / $totalMesas) * 100) : 0 }}%</span>
                        </div>
                        <div style="height: 10px; background: #fee2e2; border-radius: 5px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #22c55e, #16a34a); width: {{ $totalMesas > 0 ? round(($mesasCubiertas / $totalMesas) * 100) : 0 }}%; border-radius: 5px;"></div>
                        </div>
                    </div>
                    <div style="margin-top: 0.75rem; text-align: center;">
                        <span style="font-size: 0.8rem; color: #6b7280;">
                            {{ $totalTestigos ?? 0 }} testigos para {{ $totalMesas ?? 0 }} mesas
                            @if($totalMesas > 0 && $totalTestigos > 0)
                                (promedio {{ number_format($totalMesas / $totalTestigos, 1) }} mesas/testigo)
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Sección de Calendario y Tablas -->
            <div class="stats-grid fade-in">
                <!-- Calendario -->
                <div class="calendar-card" style="grid-column: 1 / -1; margin-bottom: 2rem;">
                    <div class="calendar-header">
                        <div class="calendar-month" id="calendar-month"></div>
                        <div class="calendar-nav">
                            <button id="prev-month">&lt;</button>
                            <button id="next-month">&gt;</button>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
                        <div class="calendar-grid">
                            <div class="weekdays">
                                <div>Dom</div><div>Lun</div><div>Mar</div><div>Mié</div><div>Jue</div><div>Vie</div><div>Sáb</div>
                            </div>
                            <div class="days" id="calendar-days"></div>
                        </div>
                        <div class="event-list">
                            <h3 style="margin: 1.5rem 0 1rem; color: #374151; font-weight: 600;">Próximas Elecciones</h3>
                            
                            <div class="event-item" onclick="jumpToDate(2, 2026)" style="cursor: pointer;" title="Ver en calendario">
                                <div class="event-date">
                                    08 <span>MAR</span>
                                </div>
                                <div class="event-info">
                                    <div class="event-title">Elecciones Congreso</div>
                                    <div class="event-desc">2026 - Votación Nacional</div>
                                </div>
                            </div>

                            <div class="event-item" onclick="jumpToDate(4, 2026)" style="cursor: pointer;" title="Ver en calendario">
                                <div class="event-date">
                                    31 <span>MAY</span>
                                </div>
                                <div class="event-info">
                                    <div class="event-title">Elecciones Presidencia</div>
                                    <div class="event-desc">2026 - Primera Vuelta</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Últimos Reportes E14 -->
                @if(isset($ultimosReportes) && $ultimosReportes->count() > 0)
                <div class="modern-card" style="grid-column: 1 / -1; padding: 0; overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="color: white; font-size: 1.25rem; font-weight: 700; margin: 0;">Últimos Reportes E14</h3>
                            <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem; margin: 0.25rem 0 0 0;">Reportes de mesas recibidos</p>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 8px;">
                            <span style="color: white; font-weight: 600;"><span id="totalReportes">{{ $totalReportes ?? 0 }}</span> reportes</span>
                        </div>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f9fafb;">
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Mesa</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Puesto</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Testigo</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Votos</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Foto E14</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimosReportes as $reporte)
                                <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                                    <td style="padding: 1rem;">
                                        <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600; font-size: 0.875rem;">
                                            Mesa #{{ $reporte->mesa->numero_mesa ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; color: #374151;">{{ $reporte->mesa->puesto->nombre ?? 'N/A' }}</td>
                                    <td style="padding: 1rem; color: #374151;">{{ $reporte->testigo->nombre ?? 'N/A' }}</td>
                                    <td style="padding: 1rem; text-align: center;">
                                        @if($reporte->total_votos)
                                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600;">
                                                {{ number_format($reporte->total_votos) }}
                                            </span>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        @if($reporte->imagen_acta)
                                            <a href="{{ Storage::url($reporte->imagen_acta) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 0.25rem; color: #059669; text-decoration: none; font-weight: 500;">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Ver
                                            </a>
                                        @else
                                            <span style="color: #9ca3af;">Sin foto</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; color: #6b7280; font-size: 0.875rem;">
                                        {{ $reporte->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Votos por Municipio -->
                @if(isset($votosPorMunicipio) && $votosPorMunicipio->count() > 0)
                <div class="modern-card" style="grid-column: 1 / -1; padding: 0; overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="color: white; font-size: 1.25rem; font-weight: 700; margin: 0;">Votos por Municipio</h3>
                            <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem; margin: 0.25rem 0 0 0;">Resumen de votos reportados por cada municipio</p>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 8px;">
                            <span style="color: white; font-weight: 600;">{{ $votosPorMunicipio->count() }} municipios con reportes</span>
                        </div>
                    </div>
                    <div style="overflow-x: auto; max-height: 400px; overflow-y: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 10;">
                                <tr style="background: #f9fafb;">
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Código</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Municipio</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Mesas</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #16a34a; border-bottom: 1px solid #e5e7eb;">Candidato</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #dc2626; border-bottom: 1px solid #e5e7eb;">Competencia</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Diferencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($votosPorMunicipio as $municipio)
                                @php
                                    $difMunicipio = ($municipio->total_votos ?? 0) - ($municipio->votos_competencia ?? 0);
                                    $esPositivoMunicipio = $difMunicipio >= 0;
                                @endphp
                                <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                                    <td style="padding: 1rem;">
                                        <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600; font-size: 0.875rem;">
                                            {{ str_pad($municipio->municipio_codigo, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; color: #374151; font-weight: 600;">{{ $municipio->municipio_nombre }}</td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600;">
                                            {{ $municipio->mesas_reportadas }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 700;">
                                            {{ number_format($municipio->total_votos ?? 0) }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 700;">
                                            {{ number_format($municipio->votos_competencia ?? 0) }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="background: {{ $esPositivoMunicipio ? '#dbeafe' : '#fef3c7' }}; color: {{ $esPositivoMunicipio ? '#1e40af' : '#92400e' }}; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 700;">
                                            {{ $esPositivoMunicipio ? '+' : '' }}{{ number_format($difMunicipio) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="position: sticky; bottom: 0;">
                                @php
                                    $totalCandidatoMun = $votosPorMunicipio->sum('total_votos');
                                    $totalCompetenciaMun = $votosPorMunicipio->sum('votos_competencia');
                                    $difTotalMun = $totalCandidatoMun - $totalCompetenciaMun;
                                @endphp
                                <tr style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); font-weight: 700;">
                                    <td colspan="2" style="padding: 1rem; color: #1e40af;">TOTAL GENERAL</td>
                                    <td style="padding: 1rem; text-align: center; color: #92400e;">{{ $votosPorMunicipio->sum('mesas_reportadas') }}</td>
                                    <td style="padding: 1rem; text-align: center; color: #166534; font-size: 1.1rem;">{{ number_format($totalCandidatoMun) }}</td>
                                    <td style="padding: 1rem; text-align: center; color: #991b1b; font-size: 1.1rem;">{{ number_format($totalCompetenciaMun) }}</td>
                                    <td style="padding: 1rem; text-align: center; color: {{ $difTotalMun >= 0 ? '#1e40af' : '#92400e' }}; font-size: 1.1rem;">{{ $difTotalMun >= 0 ? '+' : '' }}{{ number_format($difTotalMun) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Votos por Puesto -->
                @if(isset($votosPorPuesto) && $votosPorPuesto->count() > 0)
                <div class="modern-card" style="grid-column: 1 / -1; padding: 0; overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="color: white; font-size: 1.25rem; font-weight: 700; margin: 0;">Votos por Puesto</h3>
                            <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem; margin: 0.25rem 0 0 0;">Resumen de votos reportados por cada puesto de votacion</p>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 8px;">
                            <span style="color: white; font-weight: 600;">{{ $votosPorPuesto->count() }} puestos con reportes</span>
                        </div>
                    </div>
                    <div style="overflow-x: auto; max-height: 400px; overflow-y: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 10;">
                                <tr style="background: #f9fafb;">
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Municipio</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Puesto</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Mesas</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #16a34a; border-bottom: 1px solid #e5e7eb;">Candidato</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #dc2626; border-bottom: 1px solid #e5e7eb;">Competencia</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Dif.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($votosPorPuesto as $puesto)
                                @php
                                    $difPuesto = ($puesto->total_votos ?? 0) - ($puesto->votos_competencia ?? 0);
                                    $esPositivoPuesto = $difPuesto >= 0;
                                @endphp
                                <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #6b7280;">
                                        {{ str_pad($puesto->municipio_codigo, 3, '0', STR_PAD_LEFT) }} - {{ $puesto->municipio_nombre }}
                                    </td>
                                    <td style="padding: 0.75rem 1rem; color: #374151; font-weight: 500; font-size: 0.875rem;">{{ $puesto->nombre }}</td>
                                    <td style="padding: 0.75rem 1rem; text-align: center;">
                                        <span style="background: #f3e8ff; color: #7c3aed; padding: 0.2rem 0.5rem; border-radius: 12px; font-weight: 600; font-size: 0.8rem;">
                                            {{ $puesto->mesas_reportadas }}
                                        </span>
                                    </td>
                                    <td style="padding: 0.75rem 1rem; text-align: center;">
                                        <span style="background: #dcfce7; color: #166534; padding: 0.2rem 0.6rem; border-radius: 12px; font-weight: 700;">
                                            {{ number_format($puesto->total_votos ?? 0) }}
                                        </span>
                                    </td>
                                    <td style="padding: 0.75rem 1rem; text-align: center;">
                                        <span style="background: #fee2e2; color: #991b1b; padding: 0.2rem 0.6rem; border-radius: 12px; font-weight: 700;">
                                            {{ number_format($puesto->votos_competencia ?? 0) }}
                                        </span>
                                    </td>
                                    <td style="padding: 0.75rem 1rem; text-align: center;">
                                        <span style="background: {{ $esPositivoPuesto ? '#dbeafe' : '#fef3c7' }}; color: {{ $esPositivoPuesto ? '#1e40af' : '#92400e' }}; padding: 0.2rem 0.5rem; border-radius: 12px; font-weight: 700; font-size: 0.8rem;">
                                            {{ $esPositivoPuesto ? '+' : '' }}{{ number_format($difPuesto) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="position: sticky; bottom: 0;">
                                @php
                                    $totalCandidatoPuesto = $votosPorPuesto->sum('total_votos');
                                    $totalCompetenciaPuesto = $votosPorPuesto->sum('votos_competencia');
                                    $difTotalPuesto = $totalCandidatoPuesto - $totalCompetenciaPuesto;
                                @endphp
                                <tr style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); font-weight: 700;">
                                    <td colspan="2" style="padding: 1rem; color: #166534;">TOTAL GENERAL</td>
                                    <td style="padding: 1rem; text-align: center; color: #7c3aed;">{{ $votosPorPuesto->sum('mesas_reportadas') }}</td>
                                    <td style="padding: 1rem; text-align: center; color: #166534; font-size: 1.1rem;">{{ number_format($totalCandidatoPuesto) }}</td>
                                    <td style="padding: 1rem; text-align: center; color: #991b1b; font-size: 1.1rem;">{{ number_format($totalCompetenciaPuesto) }}</td>
                                    <td style="padding: 1rem; text-align: center; color: {{ $difTotalPuesto >= 0 ? '#1e40af' : '#92400e' }}; font-size: 1.1rem;">{{ $difTotalPuesto >= 0 ? '+' : '' }}{{ number_format($difTotalPuesto) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Votos por Mesa -->
                @if(isset($votosPorMesa) && $votosPorMesa->count() > 0)
                <div class="modern-card" style="grid-column: 1 / -1; padding: 0; overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="color: white; font-size: 1.25rem; font-weight: 700; margin: 0;">Votos por Mesa</h3>
                            <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem; margin: 0.25rem 0 0 0;">Detalle de votos reportados por cada mesa</p>
                        </div>
                        <div style="display: flex; gap: 1rem;">
                            <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 8px;">
                                <span style="color: white; font-weight: 600;">{{ $votosPorMesa->where('tiene_reporte', 1)->count() }} con reporte</span>
                            </div>
                            <div style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 8px;">
                                <span style="color: white; font-weight: 600;">{{ $votosPorMesa->where('tiene_reporte', 0)->count() }} sin reporte</span>
                            </div>
                        </div>
                    </div>
                    <div style="overflow-x: auto; max-height: 400px; overflow-y: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 10;">
                                <tr style="background: #f9fafb;">
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Puesto</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Mesa</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #16a34a; border-bottom: 1px solid #e5e7eb;">Candidato</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #dc2626; border-bottom: 1px solid #e5e7eb;">Competencia</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($votosPorMesa as $mesa)
                                <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s; {{ $mesa->tiene_reporte ? '' : 'opacity: 0.7;' }}" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                                    <td style="padding: 0.75rem 1rem; color: #374151; font-size: 0.875rem;">{{ $mesa->puesto_nombre }}</td>
                                    <td style="padding: 0.75rem 1rem; text-align: center;">
                                        <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.2rem 0.6rem; border-radius: 12px; font-weight: 600; font-size: 0.8rem;">
                                            #{{ $mesa->numero_mesa }}
                                        </span>
                                    </td>
                                    <td style="padding: 0.75rem 1rem; text-align: center;">
                                        @if($mesa->tiene_reporte)
                                            <span style="background: #dcfce7; color: #166534; padding: 0.2rem 0.6rem; border-radius: 12px; font-weight: 700;">
                                                {{ number_format($mesa->total_votos) }}
                                            </span>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem 1rem; text-align: center;">
                                        @if($mesa->tiene_reporte)
                                            <span style="background: #fee2e2; color: #991b1b; padding: 0.2rem 0.6rem; border-radius: 12px; font-weight: 700;">
                                                {{ number_format($mesa->votos_competencia) }}
                                            </span>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem 1rem; text-align: center;">
                                        @if($mesa->tiene_reporte)
                                            <span style="background: #dcfce7; color: #166534; padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                                Reportada
                                            </span>
                                        @else
                                            <span style="background: #fee2e2; color: #991b1b; padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="position: sticky; bottom: 0;">
                                @php
                                    $totalCandidatoMesa = $votosPorMesa->sum('total_votos');
                                    $totalCompetenciaMesa = $votosPorMesa->sum('votos_competencia');
                                @endphp
                                <tr style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); font-weight: 700;">
                                    <td colspan="2" style="padding: 1rem; color: #92400e;">TOTAL VOTOS</td>
                                    <td style="padding: 1rem; text-align: center; color: #166534; font-size: 1.1rem;">{{ number_format($totalCandidatoMesa) }}</td>
                                    <td style="padding: 1rem; text-align: center; color: #991b1b; font-size: 1.1rem;">{{ number_format($totalCompetenciaMesa) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            </div>

            <!-- Enlaces rápidos -->
            <div style="margin-top: 2rem;">
                <h3 style="color: #374151; font-size: 1rem; font-weight: 600; margin-bottom: 1rem; padding-left: 0.5rem; border-left: 3px solid #667eea;">Accesos Rápidos</h3>
            </div>
            <div class="management-grid fade-in">
                <!-- Gestión de Personas 
                <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                        <div class="icon-circle icon-blue" style="width: 50px; height: 50px; margin-right: 1rem;">
                            <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 style="color: #1f2937; font-size: 1.25rem; font-weight: bold; margin: 0;">Gestión de Personas</h3>
                    </div>
                    
                    <div>
                        <a href="{{ route('personas.index') }}" class="btn-gradient">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Ver Todas las Personas
                        </a>
                        <a href="{{ route('personas.create') }}" class="btn-secondary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Agregar Nueva Persona
                        </a>
                    </div>
                </div>-->

                <!-- Gestión de Puestos -->
                <div class="modern-card management-card">
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        <div class="icon-circle icon-green" style="margin-right: 0.75rem;">
                            <svg width="16" height="16" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 style="color: #1f2937; font-weight: bold; margin: 0;">Puestos</h3>
                    </div>

                    <div>
                        <a href="{{ route('puestos.index') }}" class="btn-gradient">Ver Puestos</a>
                        <a href="{{ route('puestos.create') }}" class="btn-secondary">+ Agregar</a>
                    </div>
                </div>

                <!-- Gestión de Testigos -->
                <div class="modern-card management-card">
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        <div class="icon-circle icon-yellow" style="margin-right: 0.75rem;">
                            <svg width="16" height="16" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 style="color: #1f2937; font-weight: bold; margin: 0;">Testigos</h3>
                    </div>

                    <div>
                        <a href="{{ route('testigos.index') }}" class="btn-gradient">Ver Testigos</a>
                        <a href="{{ route('testigos.create') }}" class="btn-secondary">+ Agregar</a>
                    </div>
                </div>
                @if(auth()->user()->canManageUsers())
                <!-- Gestión de Usuarios -->
                <div class="modern-card management-card">
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        <div class="icon-circle icon-purple" style="margin-right: 0.75rem;">
                            <svg width="16" height="16" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 style="color: #1f2937; font-weight: bold; margin: 0;">Usuarios</h3>
                    </div>

                    <div>
                        <a href="{{ route('users.index') }}" class="btn-gradient">Ver Usuarios</a>
                        <a href="{{ route('users.create') }}" class="btn-secondary">+ Crear</a>
                    </div>
                </div>
                @endif
            </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración de gráficos
            const chartColors = {
                green: '#10b981',
                greenLight: '#34d399',
                yellow: '#f59e0b',
                yellowLight: '#fbbf24',
                red: '#ef4444',
                redLight: '#f87171',
                blue: '#3b82f6',
                blueLight: '#60a5fa',
                purple: '#8b5cf6',
                purpleLight: '#a78bfa',
                gray: '#e5e7eb'
            };

            // Gráfico de Cobertura de Mesas (Dona)
            const ctxCobertura = document.getElementById('chartCoberturaMesas');
            if (ctxCobertura) {
                new Chart(ctxCobertura, {
                    type: 'doughnut',
                    data: {
                        labels: ['Cubiertas', 'Pendientes'],
                        datasets: [{
                            data: [{{ $mesasCubiertas ?? 0 }}, {{ $totalMesasPendientes ?? 0 }}],
                            backgroundColor: [chartColors.green, chartColors.yellow],
                            borderWidth: 0,
                            cutout: '70%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }

            // Gráfico de Progreso de Reportes (Dona)
            const ctxProgreso = document.getElementById('chartProgresoReportes');
            if (ctxProgreso) {
                new Chart(ctxProgreso, {
                    type: 'doughnut',
                    data: {
                        labels: ['Reportadas', 'Sin Reportar'],
                        datasets: [{
                            data: [{{ $mesasReportadas ?? 0 }}, {{ $mesasSinReportar ?? 0 }}],
                            backgroundColor: [chartColors.green, chartColors.red],
                            borderWidth: 0,
                            cutout: '70%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }

            // Gráfico Comparativo de Votos (Candidato vs Competencia)
            const ctxComparativo = document.getElementById('chartComparativoVotos');
            if (ctxComparativo) {
                new Chart(ctxComparativo, {
                    type: 'doughnut',
                    data: {
                        labels: ['Nuestro Candidato', 'Competencia'],
                        datasets: [{
                            data: [{{ $totalVotosReportados ?? 0 }}, {{ $totalVotosCompetencia ?? 0 }}],
                            backgroundColor: ['#22c55e', '#ef4444'],
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            cutout: '60%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }

            // Gráfico de Votos por Municipio (Barras Horizontales - Candidato vs Competencia)
            const ctxMunicipio = document.getElementById('chartVotosMunicipio');
            if (ctxMunicipio) {
                @if(isset($votosPorMunicipio) && $votosPorMunicipio->count() > 0)
                const municipioLabels = {!! json_encode($votosPorMunicipio->pluck('municipio_nombre')->toArray()) !!};
                const municipioVotosCandidato = {!! json_encode($votosPorMunicipio->pluck('total_votos')->toArray()) !!};
                const municipioVotosCompetencia = {!! json_encode($votosPorMunicipio->pluck('votos_competencia')->toArray()) !!};

                new Chart(ctxMunicipio, {
                    type: 'bar',
                    data: {
                        labels: municipioLabels,
                        datasets: [{
                            label: 'Nuestro Candidato',
                            data: municipioVotosCandidato,
                            backgroundColor: 'rgba(34, 197, 94, 0.8)',
                            borderColor: '#16a34a',
                            borderWidth: 1,
                            borderRadius: 4
                        }, {
                            label: 'Competencia',
                            data: municipioVotosCompetencia,
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderColor: '#dc2626',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: { boxWidth: 12, padding: 15 }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            },
                            y: {
                                grid: { display: false }
                            }
                        }
                    }
                });
                @endif
            }

            // Gráfico de Puestos por Zona (Barras)
            const ctxZona = document.getElementById('chartPuestosZona');
            if (ctxZona) {
                @if(isset($puestosPorZona) && $puestosPorZona->count() > 0)
                const zonaLabels = {!! json_encode($puestosPorZona->pluck('zona')->toArray()) !!};
                const zonaTotales = {!! json_encode($puestosPorZona->pluck('total')->toArray()) !!};

                const zonaColors = zonaLabels.map((_, i) => {
                    const colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#06b6d4', '#ec4899'];
                    return colors[i % colors.length];
                });

                new Chart(ctxZona, {
                    type: 'bar',
                    data: {
                        labels: zonaLabels.map(z => 'Zona ' + z),
                        datasets: [{
                            label: 'Puestos',
                            data: zonaTotales,
                            backgroundColor: zonaColors.map(c => c + 'cc'),
                            borderColor: zonaColors,
                            borderWidth: 1,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: { grid: { display: false } },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            }
                        }
                    }
                });
                @endif
            }

            // Gráfico de Testigos por Zona (Barras)
            const ctxTestigosZona = document.getElementById('chartTestigosZona');
            if (ctxTestigosZona) {
                @if(isset($testigosPorZona) && $testigosPorZona->count() > 0)
                const testigoZonaLabels = {!! json_encode($testigosPorZona->pluck('zona')->toArray()) !!};
                const testigoZonaTotales = {!! json_encode($testigosPorZona->pluck('total')->toArray()) !!};

                const testigoColors = testigoZonaLabels.map((_, i) => {
                    const colors = ['#8b5cf6', '#06b6d4', '#ec4899', '#3b82f6', '#10b981', '#f59e0b', '#ef4444'];
                    return colors[i % colors.length];
                });

                new Chart(ctxTestigosZona, {
                    type: 'bar',
                    data: {
                        labels: testigoZonaLabels.map(z => 'Zona ' + z),
                        datasets: [{
                            label: 'Testigos',
                            data: testigoZonaTotales,
                            backgroundColor: testigoColors.map(c => c + 'cc'),
                            borderColor: testigoColors,
                            borderWidth: 1,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: { grid: { display: false } },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            }
                        }
                    }
                });
                @endif
            }

        });

        // Global Calendar Logic (Outside DOMContentLoaded)
        window.calendarDate = new Date();
        window.calendarEvents = [
            { day: 8, month: 2, year: 2026, title: 'Congreso', type: 'event-congress' },
            { day: 31, month: 4, year: 2026, title: 'Presidencia', type: 'event' }
        ];

        window.renderCalendar = function() {
            const date = window.calendarDate;
            date.setDate(1);
            
            const calendarDays = document.getElementById('calendar-days');
            const calendarMonth = document.getElementById('calendar-month');
            
            if (!calendarDays || !calendarMonth) return;

            const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
            const firstDayIndex = date.getDay();
            const lastDayIndex = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDay();
            const nextDays = 7 - lastDayIndex - 1;

            const months = [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ];

            calendarMonth.innerHTML = `${months[date.getMonth()]} ${date.getFullYear()}`;

            let days = "";

            for (let x = firstDayIndex; x > 0; x--) {
                days += `<div class="day empty"></div>`;
            }

            for (let i = 1; i <= lastDay; i++) {
                let className = "day";
                
                const today = new Date();
                if (
                    i === today.getDate() &&
                    date.getMonth() === today.getMonth() &&
                    date.getFullYear() === today.getFullYear()
                ) {
                    className += " today";
                }

                const event = window.calendarEvents.find(e => e.day === i && e.month === date.getMonth() && e.year === date.getFullYear());
                if (event) {
                    className += " " + event.type;
                    days += `<div class="${className}" title="${event.title}">${i}</div>`;
                } else {
                    days += `<div class="${className}">${i}</div>`;
                }
            }

            for (let j = 1; j <= nextDays; j++) {
                days += `<div class="day empty"></div>`;
            }
            
            calendarDays.innerHTML = days;
        };

        window.jumpToDate = function(month, year) {
            window.calendarDate.setMonth(month);
            window.calendarDate.setFullYear(year);
            window.renderCalendar();
        };

        document.addEventListener('DOMContentLoaded', function() {
            window.renderCalendar();

            const prevMonthBtn = document.getElementById('prev-month');
            const nextMonthBtn = document.getElementById('next-month');

            if (prevMonthBtn) {
                prevMonthBtn.addEventListener('click', () => {
                    window.calendarDate.setMonth(window.calendarDate.getMonth() - 1);
                    window.renderCalendar();
                });
            }

            if (nextMonthBtn) {
                nextMonthBtn.addEventListener('click', () => {
                    window.calendarDate.setMonth(window.calendarDate.getMonth() + 1);
                    window.renderCalendar();
                });
            }
        });

        // ============================================
        // ACTUALIZACIÓN EN TIEMPO REAL DEL DASHBOARD
        // ============================================
        
        let lastTimestamp = {{ now()->timestamp }};
        let isUpdating = false;

        // Función para animar cambios en contadores
        function animateCounter(elementId, newValue) {
            const element = document.getElementById(elementId);
            if (!element) {
                console.warn(`⚠️ Elemento no encontrado: #${elementId}`);
                return;
            }

            const currentValue = parseInt(element.textContent.replace(/,/g, '')) || 0;
            if (currentValue === newValue) {
                console.log(`ℹ️ ${elementId}: Sin cambios (${currentValue})`);
                return;
            }

            console.log(`✨ Actualizando #${elementId}: ${currentValue} → ${newValue}`);

            // Animación de pulso
            element.style.transition = 'all 0.3s ease';
            element.style.transform = 'scale(1.1)';
            element.style.color = '#10b981';
            
            // Actualizar valor con formato
            element.textContent = newValue.toLocaleString('es-ES');
            
            setTimeout(() => {
                element.style.transform = 'scale(1)';
                element.style.color = '';
            }, 300);
        }

        // Función para actualizar porcentajes y barras
        function updatePercentageBar(candidatoVotos, competenciaVotos) {
            const total = candidatoVotos + competenciaVotos;
            if (total === 0) return;

            const pctCandidato = Math.round((candidatoVotos / total) * 100 * 10) / 10;
            const pctCompetencia = Math.round((competenciaVotos / total) * 100 * 10) / 10;

            // Actualizar porcentajes
            const pctElements = document.querySelectorAll('[data-candidato-pct]');
            pctElements.forEach(el => el.textContent = pctCandidato + '%');

            const pctCompElements = document.querySelectorAll('[data-competencia-pct]');
            pctCompElements.forEach(el => el.textContent = pctCompetencia + '%');

            // Actualizar barras de progreso
            const bars = document.querySelectorAll('[data-progress-bar]');
            bars.forEach(bar => {
                bar.style.width = pctCandidato + '%';
            });
        }

        // Función para actualizar tabla de últimos reportes
        function updateReportesTable(reportes) {
            const tbody = document.querySelector('table tbody');
            if (!tbody || reportes.length === 0) return;

            // Verificar si hay reportes nuevos
            const firstReporteId = tbody.querySelector('tr')?.dataset?.reporteId;
            const hasNewReportes = reportes[0].id != firstReporteId;

            if (hasNewReportes) {
                // Mostrar notificación
                showNotification('Nuevo reporte E14 recibido');

                // Reconstruir tabla
                tbody.innerHTML = reportes.map(reporte => `
                    <tr data-reporte-id="${reporte.id}" style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s; animation: fadeIn 0.5s;" 
                        onmouseover="this.style.background='#f9fafb'" 
                        onmouseout="this.style.background='white'">
                        <td style="padding: 1rem;">
                            <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600; font-size: 0.875rem;">
                                Mesa #${reporte.mesa_numero}
                            </span>
                        </td>
                        <td style="padding: 1rem; color: #374151;">${reporte.puesto_nombre}</td>
                        <td style="padding: 1rem; color: #374151;">${reporte.testigo_nombre}</td>
                        <td style="padding: 1rem; text-align: center;">
                            ${reporte.total_votos ? 
                                `<span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600;">${reporte.total_votos.toLocaleString()}</span>` : 
                                '<span style="color: #9ca3af;">-</span>'}
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            ${reporte.imagen_acta ? 
                                `<a href="/storage/${reporte.imagen_acta}" target="_blank" style="display: inline-flex; align-items: center; gap: 0.25rem; color: #059669; text-decoration: none; font-weight: 500;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Ver
                                </a>` : 
                                '<span style="color: #9ca3af;">Sin foto</span>'}
                        </td>
                        <td style="padding: 1rem; color: #6b7280; font-size: 0.875rem;">${reporte.created_at}</td>
                    </tr>
                `).join('');
            }
        }

        // Función para mostrar notificación
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 80px;
                right: 20px;
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
                z-index: 9999;
                animation: slideIn 0.3s ease-out;
                font-weight: 600;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Función principal de actualización
        async function updateDashboard() {
            if (isUpdating) {
                console.log('⏳ Actualización en progreso, saltando...');
                return;
            }
            
            isUpdating = true;
            console.log('🔄 Consultando estadísticas actualizadas...');

            try {
                const response = await fetch('{{ route("dashboard.stats") }}');
                if (!response.ok) throw new Error('Error al obtener estadísticas');

                const data = await response.json();
                console.log('📥 Datos recibidos:', data);

                // Solo actualizar si hay cambios
                if (data.timestamp > lastTimestamp) {
                    console.log('✅ Cambios detectados, actualizando dashboard');
                    console.log('  - Votos Candidato:', data.totalVotosReportados);
                    console.log('  - Votos Competencia:', data.totalVotosCompetencia);
                    console.log('  - Mesas Reportadas:', data.mesasReportadas);
                    
                    // Actualizar contadores principales
                    animateCounter('totalVotosReportados', data.totalVotosReportados);
                    animateCounter('totalVotosCompetencia', data.totalVotosCompetencia);
                    animateCounter('mesasReportadas', data.mesasReportadas);
                    animateCounter('mesasReportadas2', data.mesasReportadas);
                    animateCounter('mesasSinReportar', data.mesasSinReportar);
                    animateCounter('totalReportes', data.totalReportes);

                    // Actualizar porcentajes y barras
                    updatePercentageBar(data.totalVotosReportados, data.totalVotosCompetencia);

                    // Actualizar tabla de reportes
                    updateReportesTable(data.ultimosReportes);

                    lastTimestamp = data.timestamp;
                } else {
                    console.log('ℹ️ Sin cambios desde la última actualización');
                }
            } catch (error) {
                console.error('❌ Error actualizando dashboard:', error);
            } finally {
                isUpdating = false;
            }
        }

        // Iniciar polling cada 15 segundos
        console.log('⏰ Sistema de actualización en tiempo real iniciado - Polling cada 15 segundos');
        setInterval(updateDashboard, 15000);

        // Primera actualización inmediata para probar (después de 2 segundos)
        setTimeout(() => {
            console.log('🎯 Ejecutando primera actualización de prueba...');
            updateDashboard();
        }, 2000);

        // Agregar estilos para animaciones
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>

</x-app-layout>