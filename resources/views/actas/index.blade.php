<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
            <h2 style="font-size:1.25rem;font-weight:700;color:#1f2937;margin:0;display:flex;align-items:center;gap:0.5rem;">
                <svg width="22" height="22" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Actas de Votación
            </h2>
            <div style="display:flex;gap:0.5rem;flex-wrap:wrap;align-items:center;">
                @foreach($elecciones as $elec)
                @php $elecColor = $elec->color ?? '#667eea'; @endphp
                <span style="background:{{ $elecColor }}20;border:1px solid {{ $elecColor }}40;color:{{ $elecColor }};padding:0.2rem 0.75rem;border-radius:12px;font-size:0.72rem;font-weight:700;">
                    {{ $elec->nombre }}
                </span>
                @endforeach
            </div>
        </div>
    </x-slot>

    <style>
        body { font-family: 'Inter', sans-serif !important; background: #f1f5f9 !important; }

        .filter-bar {
            background: white; border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 1rem 1.25rem; margin-bottom: 1.25rem;
            display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: flex-end;
        }
        .filter-group { display: flex; flex-direction: column; gap: 0.25rem; flex: 1; min-width: 130px; }
        .filter-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; color: #6b7280; letter-spacing: 0.5px; }
        .filter-select {
            padding: 0.5rem 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px;
            font-size: 0.875rem; color: #1f2937; background: white; cursor: pointer;
        }
        .filter-select:focus { outline: none; border-color: #667eea; }
        .btn-clear { padding: 0.5rem 1rem; border-radius: 8px; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; font-weight: 600; font-size: 0.85rem; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; }

        .stats-row { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 0.75rem; margin-bottom: 1.25rem; }
        .stat-card { background: white; border-radius: 12px; padding: 0.9rem 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center; }
        .stat-num  { font-size: 1.6rem; font-weight: 800; line-height: 1; }
        .stat-lbl  { font-size: 0.68rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-top: 0.2rem; }

        /* ── Elección divider ── */
        .elec-divider {
            display: flex; align-items: center; gap: 0.75rem;
            margin: 1.5rem 0 0.75rem;
        }
        .elec-divider-line { flex: 1; height: 2px; }
        .elec-divider-label {
            font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.6px; padding: 0.2rem 0.9rem; border-radius: 20px;
            white-space: nowrap;
        }

        /* ── Cards ── */
        .resultado-card {
            background: white; border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
            overflow: hidden; transition: box-shadow 0.2s;
            display: flex; flex-direction: column;
        }
        .resultado-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.12); }

        .card-header {
            padding: 0.8rem 1.1rem;
            display: flex; align-items: flex-start; justify-content: space-between;
            border-bottom: 1px solid #f3f4f6;
        }
        .mesa-badge   { font-size: 1rem; font-weight: 800; color: #1e1b4b; }
        .puesto-name  { font-size: 0.75rem; color: #6b7280; margin-top: 1px; }
        .elec-badge   { font-size: 0.65rem; font-weight: 700; padding: 0.15rem 0.55rem; border-radius: 12px; white-space: nowrap; margin-top: 1px; display: inline-block; }
        .badge-estado { font-size: 0.65rem; font-weight: 700; padding: 0.2rem 0.55rem; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap; }
        .badge-bloqueada { background: #fef3c7; color: #92400e; }
        .badge-libre     { background: #dcfce7; color: #166534; }

        .card-body { padding: 0.9rem 1.1rem; flex: 1; }

        .fotos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(72px, 1fr)); gap: 0.4rem; margin-bottom: 0.6rem; }
        .foto-thumb {
            aspect-ratio: 1; border-radius: 8px; overflow: hidden;
            cursor: pointer; border: 2px solid #e5e7eb;
            transition: border-color 0.15s, transform 0.15s; position: relative;
        }
        .foto-thumb:hover { border-color: #667eea; transform: scale(1.05); }
        .foto-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .foto-num {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: rgba(0,0,0,0.5); color: white;
            font-size: 0.58rem; font-weight: 700; text-align: center; padding: 2px 0;
        }
        .no-fotos {
            background: #f9fafb; border: 2px dashed #e5e7eb; border-radius: 10px;
            padding: 0.85rem; text-align: center; color: #9ca3af; font-size: 0.8rem; margin-bottom: 0.6rem;
        }

        .votos-row { display: flex; flex-wrap: wrap; gap: 0.35rem; margin-bottom: 0.5rem; }
        .voto-chip { font-size: 0.7rem; padding: 0.18rem 0.5rem; border-radius: 20px; font-weight: 600; white-space: nowrap; }
        .voto-propio      { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .voto-competencia { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }

        .observacion-text {
            font-size: 0.75rem; color: #6b7280; line-height: 1.4; margin-bottom: 0.6rem;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }

        .card-footer {
            padding: 0.6rem 1.1rem; background: #f9fafb; border-top: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 0.72rem; color: #9ca3af;
        }
        .testigo-name { font-weight: 600; color: #4b5563; }
        .btn-desbloquear {
            font-size: 0.7rem; font-weight: 600; padding: 0.28rem 0.7rem;
            border-radius: 6px; border: none; cursor: pointer;
            background: #fef3c7; color: #92400e; transition: background 0.2s;
        }
        .btn-desbloquear:hover { background: #fde68a; }

        /* ── Lightbox ── */
        #lightbox {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.93); z-index: 99999;
            align-items: center; justify-content: center; flex-direction: column;
        }
        #lightbox img { max-width: 92vw; max-height: 82vh; object-fit: contain; border-radius: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
        .lb-nav { display: flex; gap: 1rem; margin-top: 1rem; align-items: center; }
        .lb-btn { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 0.5rem 1.2rem; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: background 0.2s; }
        .lb-btn:hover { background: rgba(255,255,255,0.25); }
        .lb-btn:disabled { opacity: 0.3; cursor: default; }
        .lb-counter { color: rgba(255,255,255,0.7); font-size: 0.85rem; min-width: 60px; text-align: center; }
        .lb-close { position: absolute; top: 1rem; right: 1.25rem; background: rgba(255,255,255,0.1); border: none; color: white; width: 2.5rem; height: 2.5rem; border-radius: 50%; font-size: 1.25rem; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .lb-info { color: rgba(255,255,255,0.6); font-size: 0.8rem; margin-top: 0.4rem; }

        @media (max-width: 640px) {
            .filter-bar { flex-direction: column; }
            .stats-row  { grid-template-columns: repeat(2, 1fr); }
        }
    </style>

    <div style="padding: 1.5rem 0;">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 1rem;">

            @if(session('success'))
            <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:0.75rem 1.1rem;margin-bottom:1rem;color:#166534;font-weight:600;font-size:0.9rem;">
                ✓ {{ session('success') }}
            </div>
            @endif

            {{-- ── FILTROS ── --}}
            <form method="GET" action="{{ route('actas.index') }}" class="filter-bar">

                <div class="filter-group">
                    <span class="filter-label">Elección</span>
                    <select name="eleccion" class="filter-select" onchange="this.form.submit()">
                        <option value="">Todas las elecciones</option>
                        @foreach($elecciones as $elec)
                        <option value="{{ $elec->id }}" {{ $eleccionFiltro == $elec->id ? 'selected' : '' }}>
                            {{ $elec->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <span class="filter-label">Municipio</span>
                    <select name="municipio" id="sel-municipio" class="filter-select" onchange="this.form.submit()">
                        <option value="">Todos los municipios</option>
                        @foreach($municipios as $m)
                        <option value="{{ $m->municipio_codigo }}" {{ $municipioFiltro == $m->municipio_codigo ? 'selected' : '' }}>
                            {{ $m->municipio_nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                @if($municipioFiltro && $puestos->count())
                <div class="filter-group">
                    <span class="filter-label">Puesto</span>
                    <select name="puesto" class="filter-select" onchange="this.form.submit()">
                        <option value="">Todos los puestos</option>
                        @foreach($puestos as $p)
                        <option value="{{ $p->id }}" {{ $puestoFiltro == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @elseif($puestoFiltro)
                    <input type="hidden" name="puesto" value="{{ $puestoFiltro }}">
                @endif

                <div class="filter-group">
                    <span class="filter-label">Fotos</span>
                    <select name="fotos" class="filter-select" onchange="this.form.submit()">
                        <option value="">Todas</option>
                        <option value="con" {{ $fotosFiltro === 'con' ? 'selected' : '' }}>Con fotos</option>
                        <option value="sin" {{ $fotosFiltro === 'sin' ? 'selected' : '' }}>Sin fotos</option>
                    </select>
                </div>

                @if($municipioFiltro || $puestoFiltro || $eleccionFiltro || $fotosFiltro)
                <a href="{{ route('actas.index') }}" class="btn-clear" style="align-self:flex-end;">
                    ✕ Limpiar
                </a>
                @endif
            </form>

            {{-- ── STATS ── --}}
            @php
                $total      = $resultados->count();
                $conFotos   = $resultados->filter(fn($r) => !empty($r->imagen_acta))->count();
                $sinFotos   = $total - $conFotos;
                $bloqueadas = $resultados->where('bloqueada', true)->count();
                $totalFotos = $resultados->sum(fn($r) => count($r->imagen_acta ?? []));
            @endphp
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-num" style="color:#667eea;">{{ $total }}</div>
                    <div class="stat-lbl">Reportes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num" style="color:#16a34a;">{{ $conFotos }}</div>
                    <div class="stat-lbl">Con fotos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num" style="color:#dc2626;">{{ $sinFotos }}</div>
                    <div class="stat-lbl">Sin fotos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num" style="color:#0891b2;">{{ $totalFotos }}</div>
                    <div class="stat-lbl">Total fotos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num" style="color:#f59e0b;">{{ $bloqueadas }}</div>
                    <div class="stat-lbl">Bloqueadas</div>
                </div>
                {{-- Por elección --}}
                @foreach($elecciones as $elec)
                @php
                    $cntElec     = $resultados->where('eleccion_id', $elec->id)->count();
                    $cntElecFoto = $resultados->where('eleccion_id', $elec->id)->filter(fn($r) => !empty($r->imagen_acta))->count();
                    $elecColor   = $elec->color ?? '#667eea';
                @endphp
                <div class="stat-card" style="border-top: 3px solid {{ $elecColor }};">
                    <div class="stat-num" style="color:{{ $elecColor }};font-size:1.3rem;">{{ $cntElec }}</div>
                    <div style="font-size:0.62rem;color:{{ $elecColor }};font-weight:700;margin-top:0.15rem;">{{ $elec->nombre }}</div>
                    <div class="stat-lbl" style="font-size:0.6rem;">{{ $cntElecFoto }} con foto</div>
                </div>
                @endforeach
            </div>

            {{-- ── RESULTADOS ── --}}
            @if($resultados->isEmpty())
            <div style="text-align:center;padding:4rem;background:white;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.07);">
                <svg style="width:3rem;height:3rem;color:#d1d5db;margin:0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p style="color:#9ca3af;font-size:1rem;">No hay reportes con los filtros seleccionados.</p>
            </div>
            @else

            @php
                // Agrupar por elección para mostrar separadores
                $porEleccion = $resultados->groupBy('eleccion_id');
            @endphp

            @foreach($elecciones as $elec)
            @php
                $grupo = $porEleccion->get($elec->id, collect());
                $elecColor = $elec->color ?? '#667eea';
            @endphp
            @if($grupo->isEmpty()) @continue @endif

            {{-- Divider de elección --}}
            <div class="elec-divider">
                <div class="elec-divider-line" style="background:{{ $elecColor }}40;"></div>
                <span class="elec-divider-label" style="background:{{ $elecColor }}15;color:{{ $elecColor }};border:1px solid {{ $elecColor }}30;">
                    {{ strtoupper($elec->tipo_cargo) }} — {{ $elec->nombre }}
                    <span style="opacity:0.7;margin-left:0.35rem;">· {{ $grupo->count() }} reportes</span>
                </span>
                <div class="elec-divider-line" style="background:{{ $elecColor }}40;"></div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem;margin-bottom:0.5rem;">
                @foreach($grupo as $resultado)
                @php
                    $fotos          = $resultado->imagen_acta ?? [];
                    $candidatoProp  = $candidatosPropios[$elec->id] ?? null;
                    $votoPropio     = null;
                    $votosComp      = [];
                    foreach ($resultado->votosCandidatos as $vc) {
                        if ($candidatoProp && $vc->candidato_id === $candidatoProp->id) {
                            $votoPropio = $vc->votos;
                        } elseif ($vc->votos > 0) {
                            $votosComp[] = $vc;
                        }
                    }
                @endphp
                <div class="resultado-card">
                    {{-- Header --}}
                    <div class="card-header" style="border-top: 3px solid {{ $elecColor }};">
                        <div>
                            <div class="mesa-badge">Mesa #{{ $resultado->mesa->numero_mesa }}</div>
                            <div class="puesto-name">
                                {{ $resultado->mesa->puesto->nombre ?? '—' }}
                                <span style="color:#9ca3af;">· {{ $resultado->mesa->puesto->municipio_nombre ?? '' }}</span>
                            </div>
                        </div>
                        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.2rem;">
                            <span class="badge-estado {{ $resultado->bloqueada ? 'badge-bloqueada' : 'badge-libre' }}">
                                {{ $resultado->bloqueada ? 'Bloqueada' : 'Editable' }}
                            </span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body">
                        {{-- Fotos --}}
                        @if(count($fotos) > 0)
                        <div class="fotos-grid">
                            @foreach($fotos as $i => $foto)
                            <div class="foto-thumb"
                                 onclick="abrirLightbox({{ json_encode(array_map(fn($f) => Storage::url($f), $fotos)) }}, {{ $i }}, 'Mesa #{{ $resultado->mesa->numero_mesa }} · {{ addslashes($resultado->mesa->puesto->nombre ?? '') }}')">
                                <img src="{{ Storage::url($foto) }}" alt="Foto {{ $i+1 }}" loading="lazy">
                                <div class="foto-num">{{ $i+1 }}</div>
                            </div>
                            @endforeach
                        </div>
                        <p style="font-size:0.7rem;color:#9ca3af;margin:0 0 0.5rem;text-align:right;">
                            {{ count($fotos) }} foto{{ count($fotos) !== 1 ? 's' : '' }}
                        </p>
                        @else
                        <div class="no-fotos">
                            <svg style="width:1.4rem;height:1.4rem;margin:0 auto 0.3rem;display:block;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Sin fotos adjuntas
                        </div>
                        @endif

                        {{-- Votos --}}
                        @if($candidatoProp || count($votosComp) > 0)
                        <div class="votos-row">
                            @if($candidatoProp && $votoPropio !== null)
                            <span class="voto-chip voto-propio">
                                ★ {{ $candidatoProp->nombre }}: <strong>{{ $votoPropio }}</strong>
                            </span>
                            @endif
                            @foreach($votosComp as $vc)
                            <span class="voto-chip voto-competencia">
                                {{ $vc->candidato->nombre }}: {{ $vc->votos }}
                            </span>
                            @endforeach
                        </div>
                        @endif

                        {{-- Observación --}}
                        @if($resultado->observacion)
                        <p class="observacion-text" title="{{ $resultado->observacion }}">
                            {{ $resultado->observacion }}
                        </p>
                        @endif
                    </div>

                    {{-- Footer --}}
                    <div class="card-footer">
                        <div>
                            <span class="testigo-name">{{ $resultado->testigo->nombre ?? 'Sin testigo' }}</span><br>
                            <span>{{ $resultado->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($resultado->bloqueada && auth()->user()->role === 'admin')
                        <form method="POST" action="{{ route('resultados.desbloquear', $resultado) }}" style="margin:0;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-desbloquear">🔓 Desbloquear</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @endforeach
            @endif

        </div>
    </div>

    {{-- ── LIGHTBOX ── --}}
    <div id="lightbox" onclick="cerrarLightbox(event)">
        <button class="lb-close" onclick="cerrarLightbox()">✕</button>
        <img id="lb-img" src="" alt="">
        <div class="lb-info" id="lb-info"></div>
        <div class="lb-nav">
            <button class="lb-btn" id="lb-prev" onclick="lbNavegar(-1)">← Anterior</button>
            <span class="lb-counter" id="lb-counter"></span>
            <button class="lb-btn" id="lb-next" onclick="lbNavegar(1)">Siguiente →</button>
        </div>
    </div>

    <script>
        let lbFotos  = [];
        let lbIndice = 0;
        let lbTitulo = '';

        function abrirLightbox(fotos, indice, titulo) {
            lbFotos  = fotos; lbIndice = indice; lbTitulo = titulo;
            lbRenderizar();
            document.getElementById('lightbox').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function lbRenderizar() {
            document.getElementById('lb-img').src            = lbFotos[lbIndice];
            document.getElementById('lb-info').textContent   = lbTitulo;
            document.getElementById('lb-counter').textContent = (lbIndice + 1) + ' / ' + lbFotos.length;
            document.getElementById('lb-prev').disabled      = lbIndice === 0;
            document.getElementById('lb-next').disabled      = lbIndice === lbFotos.length - 1;
        }

        function lbNavegar(dir) {
            const nuevo = lbIndice + dir;
            if (nuevo >= 0 && nuevo < lbFotos.length) { lbIndice = nuevo; lbRenderizar(); }
        }

        function cerrarLightbox(e) {
            if (e && e.target !== document.getElementById('lightbox') && !e.target.classList.contains('lb-close')) return;
            document.getElementById('lightbox').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', e => {
            if (document.getElementById('lightbox').style.display === 'flex') {
                if (e.key === 'ArrowLeft')  lbNavegar(-1);
                if (e.key === 'ArrowRight') lbNavegar(1);
                if (e.key === 'Escape')     cerrarLightbox({ target: document.getElementById('lightbox') });
            }
        });
    </script>
</x-app-layout>
