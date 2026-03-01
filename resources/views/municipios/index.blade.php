<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
            <h2 style="font-size:1.25rem;font-weight:700;color:#1f2937;margin:0;display:flex;align-items:center;gap:0.5rem;">
                <svg width="22" height="22" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Municipios Estratégicos
            </h2>
            <div style="display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap;">
                @foreach($elecciones as $elec)
                <span style="background:{{ $elec->color ?? '#667eea' }}20;border:1px solid {{ $elec->color ?? '#667eea' }}40;color:{{ $elec->color ?? '#667eea' }};padding:0.2rem 0.75rem;border-radius:12px;font-size:0.75rem;font-weight:600;">
                    {{ $elec->nombre }}
                </span>
                @endforeach
                <a href="{{ route('dashboard') }}" style="background:#f3f4f6;color:#374151;padding:0.3rem 0.9rem;border-radius:8px;font-size:0.8rem;font-weight:600;text-decoration:none;">
                    ← Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Resumen global por municipio --}}
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:0.75rem;margin-bottom:2rem;">
                @foreach($municipios as $mun)
                @php
                    $pctCob = $mun->total_mesas > 0 ? round(($mun->mesas_reportadas / $mun->total_mesas) * 100) : 0;
                    $totalVotosPropiMun = collect($mun->ranking_por_eleccion)->sum('votos_propio');
                @endphp
                <div style="background:white;border-radius:12px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                    <div style="background:{{ $mun->color }};padding:0.5rem 0.75rem;">
                        <div style="color:white;font-size:0.8rem;font-weight:700;">{{ $mun->nombre }}</div>
                        <div style="color:rgba(255,255,255,0.85);font-size:0.65rem;">{{ $pctCob }}% cobertura</div>
                    </div>
                    <div style="padding:0.6rem 0.75rem;display:grid;grid-template-columns:1fr 1fr;gap:0.25rem;">
                        <div style="text-align:center;">
                            <div style="font-size:1.1rem;font-weight:700;color:#166534;">{{ number_format($totalVotosPropiMun) }}</div>
                            <div style="font-size:0.6rem;color:#6b7280;">Nuestros votos</div>
                        </div>
                        <div style="text-align:center;">
                            <div style="font-size:1.1rem;font-weight:700;color:#374151;">{{ $mun->mesas_reportadas }}/{{ $mun->total_mesas }}</div>
                            <div style="font-size:0.6rem;color:#6b7280;">Mesas rep.</div>
                        </div>
                    </div>
                    {{-- barra cobertura --}}
                    <div style="height:4px;background:#f3f4f6;">
                        <div style="height:100%;width:{{ $pctCob }}%;background:{{ $mun->color }};opacity:0.7;"></div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Tarjetas detalle por municipio --}}
            @foreach($municipios as $mun)
            @php
                $pctCob = $mun->total_mesas > 0 ? round(($mun->mesas_reportadas / $mun->total_mesas) * 100) : 0;
            @endphp
            <div style="background:white;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.08);overflow:hidden;margin-bottom:1.75rem;">

                {{-- Header municipio --}}
                <div style="background:linear-gradient(135deg,{{ $mun->color }} 0%,{{ $mun->color }}cc 100%);padding:1rem 1.5rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
                    <div>
                        <h3 style="color:white;font-size:1.15rem;font-weight:700;margin:0;">{{ $mun->nombre }}</h3>
                        <div style="color:rgba(255,255,255,0.85);font-size:0.78rem;margin-top:0.15rem;">
                            {{ $mun->total_puestos }} puestos · {{ $mun->mesas_asignadas }} mesas asignadas · {{ $mun->testigos }} testigos
                        </div>
                    </div>
                    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                        <span style="background:rgba(255,255,255,0.2);color:white;padding:0.25rem 0.75rem;border-radius:12px;font-size:0.78rem;font-weight:600;">
                            {{ $mun->mesas_reportadas }} / {{ $mun->total_mesas }} reportadas
                        </span>
                        <span style="background:rgba(255,255,255,0.2);color:white;padding:0.25rem 0.75rem;border-radius:12px;font-size:0.78rem;font-weight:600;">
                            {{ $pctCob }}% cobertura
                        </span>
                    </div>
                </div>

                {{-- Barra progreso cobertura --}}
                <div style="height:5px;background:#f3f4f6;">
                    <div style="height:100%;width:{{ $pctCob }}%;background:{{ $mun->color }};transition:width 0.5s;"></div>
                </div>

                {{-- Rankings por elección --}}
                <div style="padding:1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:1.25rem;">
                    @foreach($mun->ranking_por_eleccion as $elecId => $data)
                    @php
                        $elec       = $data['eleccion'];
                        $ranking    = $data['ranking'];
                        $vProp      = $data['votos_propio'];
                        $maxVotos   = $ranking->max('total_votos') ?: 1;
                        $colorElec  = $elec->color ?? '#667eea';
                    @endphp
                    <div style="border:1px solid #f3f4f6;border-radius:12px;overflow:hidden;">
                        {{-- Sub-header elección --}}
                        <div style="background:{{ $colorElec }}15;border-bottom:2px solid {{ $colorElec }}30;padding:0.6rem 1rem;display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.8rem;font-weight:700;color:{{ $colorElec }};text-transform:uppercase;letter-spacing:0.5px;">
                                {{ $elec->nombre }}
                            </span>
                            <span style="font-size:0.78rem;font-weight:700;color:#166534;background:#dcfce7;padding:0.15rem 0.6rem;border-radius:10px;">
                                {{ number_format($vProp) }} nuestros
                            </span>
                        </div>

                        {{-- Lista de candidatos --}}
                        <div style="padding:0.75rem 1rem;">
                            @forelse($ranking as $i => $cand)
                            @php
                                $esP     = $cand->tipo === 'propio';
                                $pctBar  = round(($cand->total_votos / $maxVotos) * 100);
                                $bgCard  = $esP ? '#f0fdf4' : 'transparent';
                                $border  = $esP ? '1px solid #bbf7d0' : 'none';
                                $clrNom  = $esP ? '#166534' : '#374151';
                                $clrNum  = $esP ? '#15803d' : '#4b5563';
                                $barClr  = $esP ? 'linear-gradient(90deg,#22c55e,#16a34a)' : 'linear-gradient(90deg,#cbd5e1,#94a3b8)';
                            @endphp
                            <div style="background:{{ $bgCard }};border:{{ $border }};border-radius:8px;padding:0.4rem 0.5rem;margin-bottom:0.3rem;">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.2rem;">
                                    <div style="display:flex;align-items:center;gap:0.4rem;min-width:0;">
                                        <span style="font-size:0.65rem;color:#9ca3af;font-weight:700;width:16px;flex-shrink:0;">#{{ $i + 1 }}</span>
                                        <span style="font-size:0.8rem;font-weight:{{ $esP ? '700' : '500' }};color:{{ $clrNom }};overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            {{ $esP ? '★ ' : '' }}{{ $cand->nombre }}
                                        </span>
                                    </div>
                                    <span style="font-size:0.85rem;font-weight:700;color:{{ $clrNum }};flex-shrink:0;margin-left:0.5rem;">
                                        {{ number_format($cand->total_votos) }}
                                    </span>
                                </div>
                                <div style="height:4px;background:#e5e7eb;border-radius:2px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $pctBar }}%;background:{{ $barClr }};border-radius:2px;"></div>
                                </div>
                            </div>
                            @empty
                            <div style="text-align:center;color:#9ca3af;font-size:0.8rem;padding:1rem 0;">Sin candidatos registrados</div>
                            @endforelse
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
