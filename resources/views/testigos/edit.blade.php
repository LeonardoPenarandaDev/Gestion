<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    {{ __('Editar Testigo') }}
                </h2>
                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                    Actualiza la información del testigo electoral
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
        
        .modern-form-container {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding: 2rem;
        }
        
        .form-content {
            padding: 2.5rem;
        }
        
        .form-group {
            margin-bottom: 1.75rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 0.925rem;
        }
        
        .form-label.required::after {
            content: ' *';
            color: #ef4444;
            font-weight: bold;
            margin-left: 0.25rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.925rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            color: #374151;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .form-select {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.925rem;
            background: rgba(255, 255, 255, 0.8);
            color: #374151;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.825rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            cursor: pointer;
            gap: 0.5rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: rgba(107, 114, 128, 0.1);
            color: #374151;
            border: 2px solid #e5e7eb;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
            gap: 0.5rem;
        }
        
        .btn-secondary:hover {
            background: rgba(107, 114, 128, 0.15);
            border-color: #d1d5db;
            transform: translateY(-1px);
        }
        
        .btn-back {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #4b5563;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            gap: 0.5rem;
        }
        
        .btn-back:hover {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            transform: translateY(-1px);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .info-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fbbf24;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .info-card-text {
            color: #92400e;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .section-divider {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .form-content {
                padding: 1.5rem;
            }
        }
    </style>

    <div style="padding: 3rem 0;">
        <div style="max-width: 1000px; margin: 0 auto; padding: 0 1.5rem;">
            <div class="modern-form-container fade-in">
                <!-- Header Section -->
                <div class="form-header">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.5rem; font-weight: 700; margin: 0; color: #1f2937;">Actualizar Información</h3>
                            <p style="color: #6b7280; margin: 0.5rem 0 0 0;">Modifica los datos del testigo: {{ $testigo->nombre ?? $testigo->documento }}</p>
                        </div>
                        <a href="{{ route('testigos.show', $testigo) }}" class="btn-back">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver
                        </a>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="form-content">
                    <div class="info-card">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="info-card-text">
                            Los campos marcados con <strong>*</strong> son obligatorios.
                        </div>
                    </div>

                    <form action="{{ route('testigos.update', $testigo) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información Personal -->
                        <div class="section-title">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Información Personal
                        </div>

                        <div class="form-grid">
                            <!-- Documento -->
                            <div class="form-group">
                                <label for="documento" class="form-label required">Número de Documento</label>
                                <input type="text" name="documento" id="documento" 
                                       value="{{ old('documento', $testigo->documento) }}"
                                       class="form-input"
                                       placeholder="Ingrese el número de documento"
                                       required>
                                @error('documento')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="nombre" class="form-label required">Nombre Completo</label>
                                <input type="text" name="nombre" id="nombre" 
                                       value="{{ old('nombre', $testigo->nombre) }}"
                                       class="form-input"
                                       placeholder="Nombres y apellidos completos"
                                       maxlength="30"
                                       required>
                                @error('nombre')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Alias -->
                            <div class="form-group">
                                <label for="alias" class="form-label">Alias (Opcional)</label>
                                <input type="text" name="alias" id="alias" 
                                       value="{{ old('alias', $testigo->alias) }}"
                                       class="form-input"
                                       placeholder="Nombre corto o apodo"
                                       maxlength="20">
                                @error('alias')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Número de Mesas -->
                            <div class="form-group">
                                <label for="mesas" class="form-label required">Número de Mesa Asignada</label>
                                <input type="number" name="mesas" id="mesas" 
                                       value="{{ old('mesas', $testigo->mesas) }}"
                                       class="form-input"
                                       placeholder="1"
                                       min="1"
                                       max="99"
                                       style="text-align: center; font-weight: 600;"
                                       required>
                                @error('mesas')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Asignación Electoral -->
                        <div class="section-divider">
                            <div class="section-title">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Asignación Electoral
                            </div>

                            <div class="form-grid">
                                <!-- Zona -->
                                <div class="form-group">
                                    <label for="fk_id_zona" class="form-label required">Zona Asignada</label>
                                    <select name="fk_id_zona" id="fk_id_zona" class="form-select" required>
                                        <option value="">Seleccione una zona</option>
                                        @if(isset($zonas))
                                            @foreach($zonas as $zona)
                                                <option value="{{ $zona->id }}" {{ old('fk_id_zona', $testigo->fk_id_zona) == $zona->id ? 'selected' : '' }}>
                                                    Zona {{ $zona->zona }} - {{ $zona->nombre ?? 'Sin nombre' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('fk_id_zona')
                                        <div class="error-message">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Puesto -->
                                <div class="form-group">
                                    <label for="fk_id_puesto" class="form-label required">Puesto Asignado</label>
                                    <select name="fk_id_puesto" id="fk_id_puesto" class="form-select" required>
                                        <option value="">Primero seleccione una zona</option>
                                        @if(isset($puestos))
                                            @foreach($puestos as $puesto)
                                                <option value="{{ $puesto->id }}" {{ old('fk_id_puesto', $testigo->fk_id_puesto) == $puesto->id ? 'selected' : '' }}>
                                                    {{ $puesto->puesto }} - {{ $puesto->nombre }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('fk_id_puesto')
                                        <div class="error-message">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="form-actions">
                            <a href="{{ route('testigos.show', $testigo) }}" class="btn-secondary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" class="btn-primary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-3m-1 0V4a2 2 0 10-4 0v3m-1 0h6m-6 0V4a2 2 0 114 0v3"></path>
                                </svg>
                                Actualizar Testigo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('documento').focus();

            const documentoInput = document.getElementById('documento');
            documentoInput.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });

            const nombreInput = document.getElementById('nombre');
            nombreInput.addEventListener('input', function() {
                const words = this.value.split(' ');
                for (let i = 0; i < words.length; i++) {
                    if (words[i].length > 0) {
                        words[i] = words[i][0].toUpperCase() + words[i].slice(1).toLowerCase();
                    }
                }
                this.value = words.join(' ');
            });

            const mesasInput = document.getElementById('mesas');
            mesasInput.addEventListener('input', function() {
                if (this.value < 1) this.value = 1;
                if (this.value > 99) this.value = 99;
            });
        });
    </script>
</x-app-layout>