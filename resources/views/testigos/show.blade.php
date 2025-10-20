<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                            Detalles del Testigo
                        </h2>
                        <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                            Información completa del testigo electoral
                        </p>
                    </div>
                    <a href="{{ route('testigos.index') }}" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                </div>
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
        
        .detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 2rem;
            align-items: start;
        }
        
        .profile-sidebar {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 2rem;
            position: sticky;
            top: 2rem;
        }
        
        .detail-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .detail-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding: 1.5rem 2rem;
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .testigo-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 2.5rem;
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
            margin: 0 auto 1.5rem;
        }
        
        .testigo-info {
            text-align: center;
        }
        
        .testigo-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
        }
        
        .testigo-id {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0 0 1rem 0;
            font-weight: 500;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border: 1px solid #86efac;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        
        .btn-edit {
            flex: 1;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #fbbf24;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }
        
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(251, 191, 36, 0.3);
            text-decoration: none;
            color: #92400e;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 0.75rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(252, 165, 165, 0.3);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .info-item {
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(243, 244, 246, 0.8) 0%, rgba(229, 231, 235, 0.8) 100%);
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .info-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 1rem;
            font-weight: 600;
        }
        
        .info-value.empty {
            color: #9ca3af;
            font-style: italic;
            font-weight: 400;
        }
        
        .zone-badge {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0369a1;
            border: 1px solid #7dd3fc;
        }
        
        .puesto-badge {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #166534;
            border: 1px solid #86efac;
        }
        
        .mesa-count {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #fbbf24;
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .detail-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 2rem 1rem;
            }
            
            .profile-sidebar {
                position: static;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="detail-container fade-in">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <div class="testigo-avatar">
                {{ strtoupper(substr($testigo->nombre ?? 'T', 0, 1)) }}{{ strtoupper(substr(explode(' ', $testigo->nombre ?? 'T')[1] ?? '', 0, 1)) }}
            </div>
            <div class="testigo-info">
                <h3 class="testigo-name">{{ $testigo->nombre ?? 'Sin nombre' }}</h3>
                <p class="testigo-id">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.25rem;" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    {{ $testigo->documento ?? 'Sin documento' }}
                </p>
                <span class="status-badge">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.25rem;" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Activo
                </span>
            </div>
            
            <div class="action-buttons">
                <a href="{{ route('testigos.edit', $testigo) }}" class="btn-edit">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
                <form action="{{ route('testigos.destroy', $testigo) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este testigo?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="detail-content">
            <!-- Información Personal -->
            <div class="detail-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información Personal
                    </h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Documento
                            </div>
                            <div class="info-value">{{ $testigo->documento ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nombre
                            </div>
                            <div class="info-value">{{ $testigo->nombre ?? 'N/A' }}</div>
                        </div>

                        @if($testigo->alias)
                        <div class="info-item">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Alias
                            </div>
                            <div class="info-value">{{ $testigo->alias }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de Asignación -->
            <div class="detail-card">
    <div class="card-header">
        <h4 class="card-title">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
            </svg>
            Asignación Electoral
        </h4>
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Zona
                </div>
                <div class="info-value">
                    @if($testigo->fk_id_zona)
                        <span class="zone-badge">Zona {{ $testigo->fk_id_zona }}</span>
                    @else
                        <span class="info-value empty">Sin zona asignada</span>
                    @endif
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Puesto
                </div>
                <div class="info-value">
                    @if($testigo->puesto)
                        <span class="puesto-badge">{{ $testigo->puesto->puesto ?? 'N/A' }}</span>
                    @else
                        <span class="info-value empty">Sin puesto asignado</span>
                    @endif
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Mesas Asignadas
                </div>
                <div class="info-value">
                    <span class="mesa-count">{{ $testigo->mesas ?? '0' }} mesa{{ ($testigo->mesas ?? 0) == 1 ? '' : 's' }}</span>
                </div>
            </div>

            @if($testigo->puesto)
            <div class="info-item">
                <div class="info-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Nombre del Puesto
                </div>
                <div class="info-value" style="font-size: 0.9rem;">
                    {{ $testigo->puesto->nombre ?? 'N/A' }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Dirección del Puesto
                </div>
                <div class="info-value" style="font-size: 0.9rem;">
                    {{ $testigo->puesto->direccion ?? 'N/A' }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

            <!-- Historial de Registro -->
            <div class="detail-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Historial del Registro
                    </h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Fecha de Creación
                            </div>
                            <div class="info-value">
                                {{ $testigo->created_at ? $testigo->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Última Actualización
                            </div>
                            <div class="info-value">
                                @if($testigo->updated_at && $testigo->updated_at != $testigo->created_at)
                                    {{ $testigo->updated_at->format('d/m/Y H:i') }}
                                @else
                                    No actualizado
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>