<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">Nuevo Coordinador</h2>
                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                    Asigna un coordinador a un puesto — cubrirá todas sus mesas
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        body { font-family: 'Inter', sans-serif !important; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important; min-height: 100vh; }
        .form-card { background: white; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 2.5rem; }
        .form-section { background: #f9fafb; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 600; color: #374151; font-size: 0.875rem; margin-bottom: 0.5rem; }
        .form-input, .form-select { width: 100%; padding: 0.75rem 1rem; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; transition: border-color 0.2s; background: white; color: #1f2937; }
        .form-input:focus, .form-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .form-error { color: #ef4444; font-size: 0.8rem; margin-top: 0.35rem; font-weight: 500; }
        .section-title { font-size: 1rem; font-weight: 700; color: #1f2937; margin: 0 0 1.25rem 0; display: flex; align-items: center; gap: 0.5rem; }
    </style>

    <div style="padding: 3rem 0;">
        <div style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">
            <div style="display:flex; justify-content:flex-end; margin-bottom:1rem;">
                <a href="{{ route('coordinadores.index') }}"
                   style="background:#f3f4f6; color:#374151; padding:0.6rem 1.25rem; border-radius:8px; text-decoration:none; font-weight:500; font-size:0.875rem; border:1px solid #e5e7eb;">
                    ← Volver
                </a>
            </div>

            <div class="form-card">

                @if($errors->any())
                <div style="background:#fee2e2; border:1px solid #f87171; border-radius:10px; padding:1rem; margin-bottom:1.5rem; color:#b91c1c; font-size:0.875rem;">
                    <strong>Errores:</strong>
                    <ul style="margin:0.5rem 0 0 1rem; padding:0;">
                        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('coordinadores.store') }}">
                    @csrf

                    {{-- Ubicación --}}
                    <div class="form-section">
                        <p class="section-title">
                            <svg width="18" height="18" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/></svg>
                            Puesto Asignado
                        </p>
                        <div class="form-grid">
                            <div>
                                <label class="form-label">Municipio *</label>
                                <select id="municipio" class="form-select" required>
                                    <option value="">Seleccione un municipio</option>
                                    @foreach($municipios as $m)
                                        <option value="{{ $m->municipio_codigo }}" {{ old('municipio') == $m->municipio_codigo ? 'selected' : '' }}>
                                            {{ str_pad($m->municipio_codigo, 3, '0', STR_PAD_LEFT) }} - {{ $m->municipio_nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Zona *</label>
                                <select name="fk_id_zona" id="fk_id_zona" class="form-select" required disabled>
                                    <option value="">Primero seleccione municipio</option>
                                </select>
                                @error('fk_id_zona') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Puesto *</label>
                                <select name="fk_id_puesto" id="fk_id_puesto" class="form-select" required disabled>
                                    <option value="">Primero seleccione zona</option>
                                </select>
                                @error('fk_id_puesto') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Mesas del puesto</label>
                                <div id="mesas-info" style="padding: 0.75rem 1rem; background:#f0fdf4; border: 2px solid #86efac; border-radius:10px; color:#166534; font-weight:600; font-size:0.9rem; min-height:48px; display:flex; align-items:center;">
                                    Se mostrará al seleccionar el puesto
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Datos personales --}}
                    <div class="form-section">
                        <p class="section-title">
                            <svg width="18" height="18" fill="none" stroke="#667eea" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Datos Personales
                        </p>
                        <div class="form-grid">
                            <div>
                                <label class="form-label">Nombre Completo *</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                                       class="form-input" placeholder="Nombres y apellidos" required maxlength="60">
                                @error('nombre') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Número de Documento *</label>
                                <input type="text" name="documento" id="documento" value="{{ old('documento') }}"
                                       class="form-input" placeholder="Cédula o documento" required maxlength="20">
                                @error('documento') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Acceso portal --}}
                    <div class="form-section" style="background: linear-gradient(135deg,rgba(79,172,254,0.05),rgba(0,242,254,0.05)); border:1px solid rgba(79,172,254,0.2);">
                        <p class="section-title" style="color:#1e40af;">
                            <svg width="18" height="18" fill="none" stroke="#1e40af" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Acceso al Portal (Obligatorio)
                        </p>
                        <div class="form-grid">
                            <div>
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="form-input" placeholder="correo@ejemplo.com" required>
                                @error('email') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Contraseña *</label>
                                <input type="password" name="password" class="form-input"
                                       placeholder="Mínimo 6 caracteres" required>
                                @error('password') <p class="form-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:1.5rem;">
                        <a href="{{ route('coordinadores.index') }}"
                           style="background:white; color:#374151; padding:0.75rem 1.5rem; border-radius:10px; text-decoration:none; font-weight:600; border:2px solid #e5e7eb;">
                            Cancelar
                        </a>
                        <button type="submit"
                                style="background: linear-gradient(135deg,#667eea,#764ba2); color:white; padding:0.75rem 1.5rem; border-radius:10px; font-weight:600; border:none; cursor:pointer;">
                            Guardar Coordinador
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    const data = @json($puestosPorMunicipioZona);
    const munSel   = document.getElementById('municipio');
    const zonaSel  = document.getElementById('fk_id_zona');
    const puestoSel= document.getElementById('fk_id_puesto');
    const mesasInfo= document.getElementById('mesas-info');

    munSel.addEventListener('change', function() {
        const cod = this.value;
        zonaSel.innerHTML = '<option value="">Seleccione zona</option>';
        puestoSel.innerHTML = '<option value="">Primero seleccione zona</option>';
        mesasInfo.textContent = 'Se mostrará al seleccionar el puesto';
        zonaSel.disabled = true;
        puestoSel.disabled = true;

        if (cod && data[cod]) {
            Object.keys(data[cod].zonas).forEach(z => {
                const o = document.createElement('option');
                o.value = z; o.textContent = `Zona ${z}`;
                zonaSel.appendChild(o);
            });
            zonaSel.disabled = false;
        }
    });

    zonaSel.addEventListener('change', function() {
        const cod  = munSel.value;
        const zona = this.value;
        puestoSel.innerHTML = '<option value="">Seleccione puesto</option>';
        mesasInfo.textContent = 'Se mostrará al seleccionar el puesto';
        puestoSel.disabled = true;

        if (cod && zona && data[cod]?.zonas[zona]) {
            data[cod].zonas[zona].forEach(p => {
                const o = document.createElement('option');
                o.value = p.id;
                o.textContent = `Puesto ${p.puesto} — ${p.nombre}`;
                o.dataset.mesas = p.total_mesas;
                puestoSel.appendChild(o);
            });
            puestoSel.disabled = false;
        }
    });

    puestoSel.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        if (opt && opt.dataset.mesas) {
            mesasInfo.textContent = `✓ Este coordinador cubrirá todas las ${opt.dataset.mesas} mesas del puesto`;
        } else {
            mesasInfo.textContent = 'Se mostrará al seleccionar el puesto';
        }
    });

    // Capitalizar nombre
    document.getElementById('nombre').addEventListener('input', function() {
        const words = this.value.split(' ');
        this.value = words.map(w => w.length ? w[0].toUpperCase() + w.slice(1).toLowerCase() : w).join(' ');
    });
    // Solo números en documento
    document.getElementById('documento').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
    </script>
</x-app-layout>
