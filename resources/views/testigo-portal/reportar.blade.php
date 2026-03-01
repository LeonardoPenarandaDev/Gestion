<x-app-layout>
    <x-slot name="header">
        <div style="background: {{ $eleccion->color ?? '#4facfe' }}; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
            <div style="padding: 2rem; text-align: center;">
                <div style="display:inline-flex;align-items:center;gap:0.6rem;background:rgba(255,255,255,0.2);padding:0.35rem 1rem;border-radius:20px;margin-bottom:0.75rem;">
                    <svg style="width:1rem;height:1rem;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span style="color:white;font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;">{{ strtoupper($eleccion->tipo_cargo) }} — {{ strtoupper($eleccion->nombre) }}</span>
                </div>
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    Mesa #{{ $mesa->numero_mesa }}
                </h2>
                <p style="color: rgba(255,255,255,0.9); margin-top: 0.5rem; font-size: 0.9rem;">
                    {{ $mesa->puesto->nombre }}
                    @if($eleccion->fecha) · {{ $eleccion->fecha->format('d/m/Y') }} @endif
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

        .form-group { margin-bottom: 1.5rem; }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .form-textarea { min-height: 120px; resize: vertical; }

        .btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #2d3748;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover { background: #cbd5e0; color: #2d3748; }

        .error-message { color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem; }

        .info-box {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
            border-left: 4px solid #4facfe;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .char-counter { text-align: right; font-size: 0.75rem; color: #718096; margin-top: 0.25rem; }
        .char-counter.warning { color: #ed8936; }
        .char-counter.danger  { color: #e53e3e; }

        /* Botones de captura */
        .capture-buttons { display: flex; gap: 1rem; margin-top: 0.5rem; }

        .btn-capture {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1.25rem 1rem;
            border: 2px dashed #cbd5e0;
            border-radius: 12px;
            background: #f7fafc;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #4a5568;
        }

        .btn-capture:hover { border-color: #4facfe; background: rgba(79,172,254,0.05); color: #4facfe; }
        .btn-capture:active { transform: scale(0.98); }

        .btn-camera {
            border-color: #48bb78;
            background: linear-gradient(135deg, rgba(72,187,120,0.1) 0%, rgba(56,161,105,0.05) 100%);
            color: #276749;
        }

        .btn-camera:hover {
            border-color: #38a169;
            background: linear-gradient(135deg, rgba(72,187,120,0.2) 0%, rgba(56,161,105,0.1) 100%);
            color: #22543d;
        }

        .btn-gallery {
            border-color: #4facfe;
            background: linear-gradient(135deg, rgba(79,172,254,0.1) 0%, rgba(0,242,254,0.05) 100%);
            color: #2b6cb0;
        }

        .btn-gallery:hover {
            border-color: #3182ce;
            background: linear-gradient(135deg, rgba(79,172,254,0.2) 0%, rgba(0,242,254,0.1) 100%);
            color: #2c5282;
        }

        /* Grid de thumbnails */
        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .photo-thumb {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 1;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            border: 2px solid #e2e8f0;
        }

        .photo-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .photo-thumb .btn-remove-photo {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(229,62,62,0.9);
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            line-height: 1;
            transition: background 0.2s;
        }

        .photo-thumb .btn-remove-photo:hover { background: #c53030; }

        .photo-thumb .photo-badge {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.55);
            color: white;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 4px;
            text-align: center;
        }

        .photo-thumb.existing-photo { border-color: #48bb78; }
        .photo-thumb.new-photo      { border-color: #4facfe; }

        .photos-counter {
            font-size: 0.8rem;
            color: #718096;
            margin-top: 0.5rem;
            text-align: center;
        }

        /* Spinner de envío */
        #sendingOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
        }

        .spinner {
            width: 3rem;
            height: 3rem;
            border: 4px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 480px) {
            .capture-buttons { flex-direction: column; }
            .photos-grid { grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); }
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div style="background: linear-gradient(135deg, #f56565 0%, #c53030 100%); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(245,101,101,0.3);">
                    <strong>✗</strong> {{ session('error') }}
                </div>
            @endif

            @if($resultado && !$bloqueada)
                <div class="info-box">
                    <strong>ℹ Información:</strong> Ya existe un reporte de <strong>{{ $eleccion->nombre }}</strong> para esta mesa
                    ({{ $resultado->updated_at->format('d/m/Y H:i') }}). Puede actualizarlo si es necesario.
                </div>
            @endif

            <div class="modern-container">
                <div style="padding: 1.25rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05); background: {{ $eleccion->color ?? '#4facfe' }}18;">
                    <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
                        <span style="background:{{ $eleccion->color ?? '#4facfe' }};color:white;padding:0.3rem 0.9rem;border-radius:20px;font-weight:700;font-size:0.8rem;text-transform:uppercase;letter-spacing:0.5px;">
                            {{ $eleccion->nombre }}
                        </span>
                        <h3 style="font-size:1.2rem;font-weight:700;color:#2d3748;margin:0;">
                            Formulario E-14 · Mesa #{{ $mesa->numero_mesa }}
                        </h3>
                    </div>
                    <p style="color: #718096; margin-top: 0.4rem; margin-bottom: 0; font-size:0.875rem;">
                        {{ $mesa->puesto->nombre ?? '' }} · Complete la información del acta de votación
                    </p>
                </div>

                @if($bloqueada)
                <div style="padding: 2rem; background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border-left: 5px solid #f97316; border-radius: 0 0 20px 20px;">
                    <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                        <svg style="width:2rem;height:2rem;color:#ea580c;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <div>
                            <p style="font-weight:700;font-size:1.1rem;color:#c2410c;margin:0;">Reporte bloqueado — {{ $eleccion->nombre }}</p>
                            <p style="color:#9a3412;font-size:0.875rem;margin:0;">Este reporte ya fue enviado y no puede modificarse. Solo un administrador puede desbloquearlo.</p>
                        </div>
                    </div>
                    <div style="background:white;border-radius:12px;padding:1.25rem;border:1px solid #fed7aa;">
                        <p style="margin:0 0 0.5rem 0;color:#6b7280;font-size:0.875rem;font-weight:600;">DATOS ENVIADOS:</p>
                        @foreach($resultado->votosCandidatos->sortBy('candidato.orden') as $vc)
                            <p style="margin:0.2rem 0; font-size:0.875rem;">
                                <strong>{{ $vc->candidato->nombre }}:</strong> {{ $vc->votos }}
                                @if($vc->candidato->tipo === 'propio')
                                    <span style="color:#16a34a;font-size:0.75rem;">(nuestro candidato)</span>
                                @endif
                            </p>
                        @endforeach
                        <p style="margin:0.5rem 0 0.25rem 0;"><strong>Observación:</strong> {{ $resultado->observacion }}</p>

                        @if($resultado->imagen_acta && count($resultado->imagen_acta) > 0)
                            <p style="margin:0.5rem 0 0.25rem 0; font-weight:600;">Fotos del acta:</p>
                            <div class="photos-grid" style="max-width:400px;">
                                @foreach($resultado->imagen_acta as $img)
                                    <a href="{{ Storage::url($img) }}" target="_blank" class="photo-thumb" style="display:block;text-decoration:none;">
                                        <img src="{{ Storage::url($img) }}" alt="Acta">
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <p style="margin:0.5rem 0 0;color:#6b7280;font-size:0.8rem;">Enviado el {{ $resultado->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <a href="{{ route('testigo.portal') }}" class="btn-secondary" style="margin-top:1.5rem;display:inline-flex;">
                        <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver al portal
                    </a>
                </div>
                @else
                <form id="formReporte" action="{{ route('testigo.guardar-reporte', [$mesa->id, $eleccion->id]) }}" method="POST" enctype="multipart/form-data" style="padding: 2rem;">
                    @csrf

                    {{-- ── SECCIÓN DE FOTOS ── --}}
                    <div class="form-group">
                        <label class="form-label">
                            <svg style="width:1rem;height:1rem;display:inline;margin-right:0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Fotos del Formulario E14
                            <span style="color:#718096;font-weight:400;text-transform:none;font-size:0.8rem;">(puedes subir varias)</span>
                        </label>

                        <div class="capture-buttons">
                            <label class="btn-capture btn-camera" for="camera_input">
                                <svg style="width:1.5rem;height:1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Tomar Foto</span>
                                <span style="font-size:0.7rem;font-weight:400;opacity:0.75;">toca varias veces para agregar más</span>
                            </label>
                            <label class="btn-capture btn-gallery" for="gallery_input">
                                <svg style="width:1.5rem;height:1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Galería</span>
                                <span style="font-size:0.7rem;font-weight:400;opacity:0.75;">selecciona una o varias</span>
                            </label>
                        </div>

                        {{-- Input cámara: captura una foto a la vez --}}
                        <input type="file" id="camera_input" accept="image/*" capture="environment"
                               style="display:none;" onchange="agregarFotos(this)">

                        {{-- Input galería: permite seleccionar múltiples --}}
                        <input type="file" id="gallery_input" accept="image/jpeg,image/png,image/jpg"
                               multiple style="display:none;" onchange="agregarFotos(this)">

                        <p style="color:#718096;font-size:0.8rem;margin-top:0.6rem;text-align:center;">
                            JPG o PNG · máx 10 fotos · se comprimen automáticamente
                        </p>

                        @error('imagenes_acta')   <p class="error-message">{{ $message }}</p> @enderror
                        @error('imagenes_acta.*') <p class="error-message">{{ $message }}</p> @enderror

                        {{-- Grid de fotos (existentes + nuevas) --}}
                        <div id="photosGrid" class="photos-grid">
                            {{-- Fotos ya guardadas en BD para esta elección --}}
                            @if($resultado && $resultado->imagen_acta)
                                @foreach($resultado->imagen_acta as $idx => $img)
                                    <div class="photo-thumb existing-photo" id="existing-{{ $idx }}">
                                        <img src="{{ Storage::url($img) }}" alt="Foto {{ $idx+1 }}">
                                        <button type="button" class="btn-remove-photo"
                                                onclick="quitarFotoExistente({{ $idx }}, '{{ $img }}')"
                                                title="Quitar foto">✕</button>
                                        <div class="photo-badge">Guardada</div>
                                        {{-- hidden para indicar al server que se conserva --}}
                                        <input type="hidden" name="imagenes_existentes[]" value="{{ $img }}" id="keep-{{ $idx }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="photosCounter" class="photos-counter" style="display:none;"></div>
                    </div>

                    {{-- ── VOTOS para esta elección ── --}}
                    @php
                        $propiosElec = $eleccion->candidatos->where('tipo','propio');
                        $compElec    = $eleccion->candidatos->where('tipo','competencia');
                    @endphp

                    @if($eleccion->candidatos->isEmpty())
                        <div style="background:#fff7ed;border:2px solid #fed7aa;border-radius:12px;padding:1.5rem;margin-bottom:1.25rem;text-align:center;color:#92400e;font-weight:600;">
                            Esta elección no tiene candidatos activos. Contacta al administrador.
                        </div>
                    @else

                    @if($propiosElec->count())
                    <div style="background:#f0fdf4;border:2px solid #86efac;border-radius:10px;padding:0.85rem;margin-bottom:0.85rem;">
                        <p style="font-weight:700;color:#166534;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 0.6rem 0;">✔ Nuestros candidatos</p>
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:0.65rem;">
                            @foreach($propiosElec as $candidato)
                            <div>
                                <label style="display:block;font-size:0.8rem;font-weight:700;color:#166534;margin-bottom:0.25rem;">{{ $candidato->nombre }}</label>
                                <input type="number" name="votos_candidato[{{ $candidato->id }}]"
                                       class="form-input" style="border-color:#86efac;"
                                       placeholder="Votos" min="0"
                                       value="{{ old('votos_candidato.'.$candidato->id, $votosPrevios[$candidato->id] ?? '') }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($compElec->count())
                    <div style="background:#fef2f2;border:2px solid #fca5a5;border-radius:10px;padding:0.85rem;margin-bottom:1.25rem;">
                        <p style="font-weight:700;color:#dc2626;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 0.6rem 0;">
                            ✗ Competencia — {{ $compElec->count() }} candidatos
                        </p>
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:0.65rem;">
                            @foreach($compElec as $candidato)
                            <div>
                                <label style="display:block;font-size:0.78rem;font-weight:600;color:#4a5568;margin-bottom:0.25rem;">{{ $candidato->nombre }}</label>
                                <input type="number" name="votos_candidato[{{ $candidato->id }}]"
                                       class="form-input" style="border-color:#fca5a5;padding:0.5rem 0.75rem;"
                                       placeholder="0" min="0"
                                       value="{{ old('votos_candidato.'.$candidato->id, $votosPrevios[$candidato->id] ?? '') }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @endif

                    {{-- ── OBSERVACIONES ── --}}
                    <div class="form-group">
                        <label for="observacion" class="form-label">
                            <svg style="width:1rem;height:1rem;display:inline;margin-right:0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Observaciones <span style="color:#e53e3e;">*</span>
                        </label>
                        <textarea id="observacion" name="observacion" class="form-input form-textarea"
                                  placeholder="Describa los resultados de la votación, observaciones importantes, irregularidades detectadas, etc."
                                  required maxlength="1000"
                                  oninput="updateCharCount()">{{ old('observacion', $resultado->observacion ?? '') }}</textarea>
                        <div id="charCounter" class="char-counter">
                            <span id="charCount">0</span> / 1000 caracteres
                        </div>
                        @error('observacion') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div style="display:flex;gap:1rem;margin-top:2rem;flex-wrap:wrap;">
                        <button type="button" onclick="abrirModal()" class="btn-primary">
                            <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $resultado ? 'Actualizar Reporte' : 'Enviar Reporte' }}
                        </button>
                        <a href="{{ route('testigo.portal') }}" class="btn-secondary">
                            <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Volver
                        </a>
                    </div>
                </form>
                @endif

                {{-- Modal de confirmación --}}
                <div id="modalConfirm" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9999;align-items:center;justify-content:center;">
                    <div style="background:white;border-radius:20px;padding:2rem;max-width:420px;width:90%;box-shadow:0 25px 50px rgba(0,0,0,0.3);text-align:center;">
                        <div style="width:4rem;height:4rem;background:linear-gradient(135deg,#f97316,#ea580c);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
                            <svg style="width:2rem;height:2rem;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:1.3rem;font-weight:700;color:#1a202c;margin:0 0 0.5rem;">¿Confirmar envío?</h3>
                        <div style="background:{{ $eleccion->color ?? '#4facfe' }}20;border:2px solid {{ $eleccion->color ?? '#4facfe' }};border-radius:10px;padding:0.5rem 1rem;margin-bottom:0.75rem;display:inline-block;">
                            <span style="color:{{ $eleccion->color ?? '#4facfe' }};font-weight:700;font-size:0.95rem;">{{ $eleccion->nombre }} — Mesa #{{ $mesa->numero_mesa }}</span>
                        </div>
                        <p style="color:#4a5568;margin:0 0 0.5rem;">Una vez enviado, quedará <strong>bloqueado</strong> y no podrás modificarlo.</p>
                        <p style="color:#e53e3e;font-size:0.875rem;margin:0 0 1.75rem;">Solo un administrador podrá desbloquearlo.</p>
                        <div style="display:flex;gap:1rem;justify-content:center;">
                            <button onclick="cerrarModal()" style="flex:1;padding:0.75rem;border-radius:8px;border:2px solid #e2e8f0;background:white;font-weight:600;color:#4a5568;cursor:pointer;font-size:1rem;">
                                Cancelar
                            </button>
                            <button onclick="confirmarEnvio()" style="flex:1;padding:0.75rem;border-radius:8px;border:none;background:linear-gradient(135deg,#4facfe,#00f2fe);color:white;font-weight:700;cursor:pointer;font-size:1rem;box-shadow:0 4px 15px rgba(79,172,254,0.3);">
                                Sí, enviar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Overlay de envío --}}
    <div id="sendingOverlay">
        <div class="spinner"></div>
        <p style="color:white;font-weight:600;font-size:1rem;">Enviando reporte y fotos…</p>
    </div>

    <script>
        // ─── URL del endpoint de pre-subida (ruta relativa, funciona sin importar APP_URL) ───
        const UPLOAD_URL  = '{{ route("testigo.upload-temp") }}';
        const CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]')?.content
                            || '{{ csrf_token() }}';
        const MAX_FOTOS   = 10;
        let subiendo      = 0;   // contador de subidas en curso

        function contarFotosTotal() {
            return document.querySelectorAll('.photo-thumb').length;
        }

        // ─── Cuando el usuario selecciona fotos ───────────────────────────
        function agregarFotos(input) {
            const archivos = Array.from(input.files);
            input.value = ''; // reset inmediato para poder volver a usarlo

            archivos.forEach(file => {
                if (contarFotosTotal() >= MAX_FOTOS) {
                    alert('Límite de ' + MAX_FOTOS + ' fotos alcanzado.');
                    return;
                }
                if (file.size > 50 * 1024 * 1024) {
                    alert('"' + file.name + '" supera 50 MB. Por favor elige otra foto.');
                    return;
                }
                subirFoto(file);
            });
        }

        // ─── Comprimir imagen antes de subir (max 1920px, JPEG 82%) ─────
        function comprimirImagen(file) {
            return new Promise(resolve => {
                // Si ya es pequeña, no comprimir
                if (file.size < 800 * 1024) { resolve(file); return; }

                const url = URL.createObjectURL(file);
                const img = new Image();
                img.onerror = () => { URL.revokeObjectURL(url); resolve(file); };
                img.onload  = () => {
                    URL.revokeObjectURL(url);
                    const MAX = 1920;
                    let w = img.naturalWidth, h = img.naturalHeight;
                    if (w > MAX || h > MAX) {
                        if (w >= h) { h = Math.round(h * MAX / w); w = MAX; }
                        else        { w = Math.round(w * MAX / h); h = MAX; }
                    }
                    const canvas = document.createElement('canvas');
                    canvas.width = w; canvas.height = h;
                    canvas.getContext('2d').drawImage(img, 0, 0, w, h);
                    canvas.toBlob(blob => resolve(blob || file), 'image/jpeg', 0.82);
                };
                img.src = url;
            });
        }

        // ─── Pre-subir una foto al servidor ──────────────────────────────
        function subirFoto(file) {
            const uid   = 'foto-' + Date.now() + '-' + Math.random().toString(36).slice(2);
            const thumb = crearThumbCargando(uid, file);

            subiendo++;
            document.getElementById('photosGrid').appendChild(thumb);
            actualizarContador();

            // Mostrar preview local inmediatamente
            const reader = new FileReader();
            reader.onload = e => {
                const img = thumb.querySelector('img');
                if (img) { img.src = e.target.result; img.style.opacity = '0.6'; }
            };
            reader.readAsDataURL(file);

            // Comprimir y subir
            comprimirImagen(file).then(comprimida => {
                const fd = new FormData();
                fd.append('imagen', comprimida, file.name.replace(/\.[^.]+$/, '.jpg'));
                fd.append('_token', CSRF_TOKEN);
                return fetch(UPLOAD_URL, { method: 'POST', body: fd });
            })
            .then(r => {
                if (!r.ok) return r.text().then(t => Promise.reject('HTTP ' + r.status + ': ' + t));
                return r.json();
            })
            .then(data => {
                thumb.classList.remove('uploading');
                thumb.querySelector('.upload-spinner')?.remove();
                thumb.querySelector('img').style.opacity = '1';
                thumb.querySelector('.photo-badge').textContent = 'Lista';
                const hidden = document.createElement('input');
                hidden.type  = 'hidden';
                hidden.name  = 'imagenes_temp[]';
                hidden.value = data.temp_path;
                hidden.id    = 'temp-' + uid;
                thumb.appendChild(hidden);
            })
            .catch(err => {
                thumb.style.borderColor = '#e53e3e';
                thumb.querySelector('.photo-badge').textContent = 'Error al subir';
                thumb.querySelector('.photo-badge').style.background = 'rgba(229,62,62,0.85)';
                thumb.querySelector('img').style.opacity = '0.4';
                console.error('Error subiendo imagen:', err);
            })
            .finally(() => {
                subiendo--;
                actualizarContador();
            });
        }

        function crearThumbCargando(uid, file) {
            const div = document.createElement('div');
            div.className = 'photo-thumb new-photo uploading';
            div.id = uid;
            div.innerHTML = `
                <img src="" alt="${file.name}" style="opacity:0.5;">
                <div class="upload-spinner" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.5);">
                    <div style="width:24px;height:24px;border:3px solid #cbd5e0;border-top-color:#4facfe;border-radius:50%;animation:spin 0.8s linear infinite;"></div>
                </div>
                <button type="button" class="btn-remove-photo" onclick="quitarFoto('${uid}')" title="Quitar">✕</button>
                <div class="photo-badge">Subiendo…</div>
            `;
            return div;
        }

        function quitarFoto(uid) {
            document.getElementById(uid)?.remove();
            actualizarContador();
        }

        function quitarFotoExistente(idx) {
            document.getElementById('keep-' + idx)?.remove();
            document.getElementById('existing-' + idx)?.remove();
            actualizarContador();
        }

        function actualizarContador() {
            const total   = contarFotosTotal();
            const counter = document.getElementById('photosCounter');
            if (total > 0) {
                counter.style.display = 'block';
                const subiendoTxt = subiendo > 0 ? ` (${subiendo} subiendo…)` : '';
                counter.textContent = total + ' foto' + (total !== 1 ? 's' : '') + subiendoTxt;
            } else {
                counter.style.display = 'none';
            }
        }

        // ─── Modal y envío ────────────────────────────────────────────────
        function abrirModal() {
            if (subiendo > 0) {
                alert('Espera a que terminen de subir las fotos (' + subiendo + ' pendiente/s).');
                return;
            }
            document.getElementById('modalConfirm').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modalConfirm').style.display = 'none';
        }

        function confirmarEnvio() {
            cerrarModal();
            document.getElementById('sendingOverlay').style.display = 'flex';
            // El formulario se envía de forma normal (browser POST con redirect correcto)
            document.getElementById('formReporte').submit();
        }

        // ─── Contador de caracteres ───────────────────────────────────────
        function updateCharCount() {
            const textarea = document.getElementById('observacion');
            const counter  = document.getElementById('charCount');
            const wrapper  = document.getElementById('charCounter');
            const length   = textarea.value.length;
            counter.textContent = length;
            wrapper.classList.remove('warning', 'danger');
            if (length > 900) wrapper.classList.add('danger');
            else if (length > 750) wrapper.classList.add('warning');
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCharCount();
            actualizarContador();
        });

        document.getElementById('modalConfirm').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>
</x-app-layout>
