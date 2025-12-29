<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    {{ __('Nuevo Testigo') }}
                </h2>
                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                    Registra un nuevo testigo electoral en el sistema
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
            display: flex;
            align-items: center;
        }
        
        .form-label.required::after {
            content: ' *';
            color: #ef4444;
            font-weight: bold;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.925rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            color: #374151;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }
        
        .form-input:hover {
            border-color: #d1d5db;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .form-select {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.925rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            color: #374151;
            cursor: pointer;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.95);
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
            font-size: 0.925rem;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
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
            font-size: 0.925rem;
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            background: rgba(107, 114, 128, 0.15);
            border-color: #d1d5db;
            transform: translateY(-1px);
            color: #374151;
            text-decoration: none;
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
        }
        
        .btn-back:hover {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            transform: translateY(-1px);
            color: #4b5563;
            text-decoration: none;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        .form-grid-full {
            grid-column: span 2;
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
        
        .input-icon {
            position: relative;
        }
        
        .input-icon svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }
        
        .input-icon .form-input {
            padding-left: 2.75rem;
        }
        
        .info-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fbbf24;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .info-card svg {
            margin-right: 0.75rem;
            color: #92400e;
        }
        
        .info-card-text {
            color: #92400e;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .relation-section {
            background: linear-gradient(135deg, rgba(243, 244, 246, 0.8) 0%, rgba(229, 231, 235, 0.8) 100%);
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .relation-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .form-grid-full {
                grid-column: span 1;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .form-content {
                padding: 1.5rem;
            }
            
            .form-header {
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
                            <h3 style="font-size: 1.5rem; font-weight: 700; margin: 0; color: #1f2937;">Agregar Nuevo Testigo</h3>
                            <p style="color: #6b7280; margin: 0.5rem 0 0 0;">Complete la información para registrar un nuevo testigo electoral</p>
                        </div>
                        <a href="{{ route('testigos.index') }}" class="btn-back">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.18 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div class="info-card-text">
                            Un testigo debe estar asociado a una zona y puesto específico. Los campos marcados con <strong>*</strong> son obligatorios.
                        </div>
                    </div>

                    <form action="{{ route('testigos.store') }}" method="POST">
                        @csrf
                        
                        <!-- Información Básica -->
                        <div class="form-grid">
                            <!-- FK Zona -->
                            <div class="form-group">
                            <label for="fk_id_zona" class="form-label required">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Zona Asignada
                            </label>
                            <select name="fk_id_zona" id="fk_id_zona" class="form-select" required>
                                <option value="">Seleccione una zona</option>
                                @if(isset($zonas))
                                    @foreach($zonas as $zona)
                                        <option value="{{ $zona->zona }}" {{ old('fk_id_zona') == $zona->zona ? 'selected' : '' }}>
                                            Zona {{ $zona->zona }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            
                            @error('fk_id_zona')
                                <div class="error-message">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                            <!-- FK Puesto -->
                            <div class="form-group">
                                <label for="fk_id_puesto" class="form-label required">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Puesto Asignado
                                </label>
                                <select name="fk_id_puesto" id="fk_id_puesto" class="form-select" required>
                                    <option value="">Primero seleccione una zona</option>
                                </select>
                                @error('fk_id_puesto')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            

                            <!--    agregando lugar de votacion -->

                            <div class="form-group">
                            <label for="fk_id_nombre" class="form-label required">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Nombre del Puesto
                            </label>
                            <select id="fk_id_nombre" class="form-select" disabled>
                                <option value="">Seleccione nombre del puesto</option>
                            </select>
                            <small style="color: #6b7280; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                Se actualiza automáticamente al seleccionar el puesto
                            </small>
                        </div>

                        <!-- Dirección del Puesto - SOLO PARA VISUALIZACIÓN, NO ENVÍA DATOS -->
                        <div class="form-group">
                            <label for="fk_id_direccion" class="form-label required">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Dirección del Puesto
                            </label>
                            <select id="fk_id_direccion" class="form-select" disabled>
                                <option value="">Seleccione dirección</option>
                            </select>
                            <small style="color: #6b7280; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                Se actualiza automáticamente al seleccionar el puesto
                            </small>
                        </div>



                            <!--    agregando lugar de votacion -->

                            




                        </div>

                        <!-- Información Personal -->
                        <div class="form-grid">
                            <!-- Documento -->
                            <div class="form-group">
                                <label for="documento" class="form-label required">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 112 0v2m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0h2a2 2 0 012 2v2H9V6z"></path>
                                    </svg>
                                    Número de Documento
                                </label>
                                <div class="input-icon">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <input type="text" name="documento" id="documento" 
                                           value="{{ old('documento') }}"
                                           class="form-input"
                                           placeholder="Ingrese el número de documento"
                                           required>
                                </div>
                                @error('documento')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="nombre" class="form-label required">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Nombre Completo
                                </label>
                                <div class="input-icon">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <input type="text" name="nombre" id="nombre" 
                                           value="{{ old('nombre') }}"
                                           class="form-input"
                                           placeholder="Nombres y apellidos completos"
                                           maxlength="30"
                                           required>
                                </div>
                                @error('nombre')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="form-grid">
                            <!-- Múltiples Mesas -->
                            <div class="form-group form-grid-full">
                                <label for="mesas" class="form-label required">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Mesas Asignadas
                                </label>
                                <div id="mesas-container" style="padding: 1rem; background: rgba(243, 244, 246, 0.5); border-radius: 12px; border: 2px solid #e5e7eb; min-height: 100px;">
                                    <p style="color: #6b7280; font-size: 0.875rem; text-align: center; margin: 2rem 0;">
                                        Seleccione un puesto para ver las mesas disponibles
                                    </p>
                                </div>
                                @error('mesas')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                                @error('mesas.*')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Alias -->
                            <div class="form-group">
                                <label for="alias" class="form-label">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Alias (Opcional)
                                </label>
                                <div class="input-icon">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <input type="text" name="alias" id="alias" 
                                           value="{{ old('alias') }}"
                                           class="form-input"
                                           placeholder="Nombre corto o apodo"
                                           maxlength="20">
                                </div>
                                @error('alias')
                                    <div class="error-message">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Relaciones -->
                        <div class="relation-section">
                            <div class="relation-title">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Asignación de Puesto
                            </div>
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                                El testigo será asignado al puesto seleccionado y será responsable de las mesas indicadas en dicha ubicación.
                            </p>
                            <div id="puesto-info" style="padding: 1rem; background: rgba(243, 244, 246, 0.5); border-radius: 8px; display: none;">
                                <div style="font-size: 0.875rem; color: #4b5563;">
                                    <strong>Información del puesto:</strong>
                                    <div id="puesto-details"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="form-actions">
                            <a href="{{ route('testigos.index') }}" class="btn-secondary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" class="btn-primary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Guardar Testigo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus en el primer campo
    document.getElementById('fk_id_zona').focus();
    
    // Datos de puestos por zona desde el backend
    // Estructura: { "Norte": [...], "Sur": [...], "Centro": [...] }
    const puestosPorZona = @json($puestosPorZona ?? []);
    console.log('Puestos por zona:', puestosPorZona); // Para debug
    
    const zonaSelect = document.getElementById('fk_id_zona');
    const puestoSelect = document.getElementById('fk_id_puesto');
    const nombreSelect = document.getElementById('fk_id_nombre');
    const direccionSelect = document.getElementById('fk_id_direccion');
    const puestoInfo = document.getElementById('puesto-info');
    const puestoDetails = document.getElementById('puesto-details');
    
    // Función para actualizar puestos según la zona seleccionada
    zonaSelect.addEventListener('change', function() {
        const zonaId = this.value; // Aquí zonaId es el nombre de la zona (ej: "Norte")
        
        // Limpiar todos los selectores
        puestoSelect.innerHTML = '<option value="">Seleccione un puesto</option>';
        nombreSelect.innerHTML = '<option value="">Seleccione nombre del puesto</option>';
        direccionSelect.innerHTML = '<option value="">Seleccione dirección</option>';
        puestoInfo.style.display = 'none';
        
        if (zonaId && puestosPorZona[zonaId] && puestosPorZona[zonaId].length > 0) {
            puestosPorZona[zonaId].forEach(puesto => {
                // Opción para Puesto Asignado
                const puestoOption = document.createElement('option');
                puestoOption.value = puesto.id;
                puestoOption.textContent = `Puesto ${puesto.puesto} - ${puesto.nombre}`;
                puestoOption.dataset.info = JSON.stringify(puesto);
                puestoSelect.appendChild(puestoOption);
                
                // Opción para Nombre del Puesto
                const nombreOption = document.createElement('option');
                nombreOption.value = puesto.id;
                nombreOption.textContent = puesto.nombre;
                nombreOption.dataset.info = JSON.stringify(puesto);
                nombreSelect.appendChild(nombreOption);
                
                // Opción para Dirección del Puesto
                const direccionOption = document.createElement('option');
                direccionOption.value = puesto.id;
                direccionOption.textContent = puesto.direccion;
                direccionOption.dataset.info = JSON.stringify(puesto);
                direccionSelect.appendChild(direccionOption);
            });
            
            puestoSelect.disabled = false;
            nombreSelect.disabled = false;
            direccionSelect.disabled = false;
        } else {
            puestoSelect.disabled = true;
            nombreSelect.disabled = true;
            direccionSelect.disabled = true;
            if (zonaId) {
                console.warn('No hay puestos para la zona:', zonaId);
            }
        }
    });
    
    // Mostrar información cuando se selecciona un puesto
    puestoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const mesasContainer = document.getElementById('mesas-container');
        
        if (selectedOption.dataset.info) {
            const puesto = JSON.parse(selectedOption.dataset.info);
            puestoDetails.innerHTML = `
                <div style="margin-top: 0.5rem;">
                    <strong>Nombre:</strong> ${puesto.nombre}<br>
                    <strong>Dirección:</strong> ${puesto.direccion}<br>
                    <strong>Total mesas disponibles:</strong> ${puesto.total_mesas}
                </div>
            `;
            puestoInfo.style.display = 'block';
            
            // Sincronizar con los otros selectores
            nombreSelect.value = puesto.id;
            direccionSelect.value = puesto.id;
            
            // Generar checkboxes para las mesas
            const totalMesas = parseInt(puesto.total_mesas) || 0;
            if (totalMesas > 0) {
                let checkboxesHTML = '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 0.75rem;">';
                
                for (let i = 1; i <= totalMesas; i++) {
                    checkboxesHTML += `
                        <label style="display: flex; align-items: center; padding: 0.5rem; background: white; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s;" class="mesa-checkbox-label">
                            <input type="checkbox" name="mesas[]" value="${i}" style="margin-right: 0.5rem; width: 16px; height: 16px; cursor: pointer;" class="mesa-checkbox">
                            <span style="font-weight: 600; color: #374151;">Mesa ${i}</span>
                        </label>
                    `;
                }
                
                checkboxesHTML += '</div>';
                checkboxesHTML += '<div style="margin-top: 1rem; padding: 0.75rem; background: rgba(59, 130, 246, 0.1); border-radius: 8px; display: none;" id="mesas-selected-info"><span style="color: #1e40af; font-weight: 500;">Mesas seleccionadas: <strong id="mesas-count">0</strong></span></div>';
                
                mesasContainer.innerHTML = checkboxesHTML;
                
                // Agregar event listeners a los checkboxes
                const checkboxes = mesasContainer.querySelectorAll('.mesa-checkbox');
                const labels = mesasContainer.querySelectorAll('.mesa-checkbox-label');
                const selectedInfo = document.getElementById('mesas-selected-info');
                const countSpan = document.getElementById('mesas-count');
                
                checkboxes.forEach((checkbox, index) => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            labels[index].style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                            labels[index].style.borderColor = '#667eea';
                            labels[index].querySelector('span').style.color = 'white';
                        } else {
                            labels[index].style.background = 'white';
                            labels[index].style.borderColor = '#e5e7eb';
                            labels[index].querySelector('span').style.color = '#374151';
                        }
                        
                        // Actualizar contador
                        const selectedCount = mesasContainer.querySelectorAll('.mesa-checkbox:checked').length;
                        countSpan.textContent = selectedCount;
                        selectedInfo.style.display = selectedCount > 0 ? 'block' : 'none';
                    });
                });
            } else {
                mesasContainer.innerHTML = '<p style="color: #ef4444; font-size: 0.875rem; text-align: center; margin: 2rem 0;">Este puesto no tiene mesas disponibles</p>';
            }
        } else {
            puestoInfo.style.display = 'none';
            mesasContainer.innerHTML = '<p style="color: #6b7280; font-size: 0.875rem; text-align: center; margin: 2rem 0;">Seleccione un puesto para ver las mesas disponibles</p>';
        }
    });
    
    // Nota: nombreSelect y direccionSelect son solo para visualización
    // No se envían al servidor, solo se actualizan cuando cambia puestoSelect


    // Formatear documento (solo números)
    const documentoInput = document.getElementById('documento');
    if (documentoInput) {
        documentoInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    }

    // Capitalizar nombres automáticamente
    const nombreInput = document.getElementById('nombre');
    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            const words = this.value.split(' ');
            for (let i = 0; i < words.length; i++) {
                if (words[i].length > 0) {
                    words[i] = words[i][0].toUpperCase() + words[i].slice(1).toLowerCase();
                }
            }
            this.value = words.join(' ');
        });
    }

    // Contadores de caracteres
    const limitedInputs = [
        { element: document.getElementById('nombre'), limit: 30 },
        { element: document.getElementById('alias'), limit: 20 }
    ];

    limitedInputs.forEach(({ element, limit }) => {
        if (element) {
            const counter = document.createElement('div');
            counter.style.cssText = 'font-size: 0.75rem; color: #6b7280; text-align: right; margin-top: 0.25rem;';
            counter.textContent = `0/${limit} caracteres`;
            
            element.parentNode.appendChild(counter);
            
            element.addEventListener('input', function() {
                const current = this.value.length;
                counter.textContent = `${current}/${limit} caracteres`;
                
                if (current > limit * 0.9) {
                    counter.style.color = '#ef4444';
                } else if (current > limit * 0.7) {
                    counter.style.color = '#f59e0b';
                } else {
                    counter.style.color = '#6b7280';
                }
            });
            
            if (element.value) {
                element.dispatchEvent(new Event('input'));
            }
        }
    });

    // Validación en tiempo real para campos requeridos
    const requiredInputs = [
        document.getElementById('fk_id_zona'),
        document.getElementById('fk_id_puesto'),
        document.getElementById('documento'),
        document.getElementById('nombre'),
        document.getElementById('mesas')
    ];

    requiredInputs.forEach(input => {
        if (input) {
            input.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '#10b981';
                }
            });
        }
    });
});
    </script>
</x-app-layout>