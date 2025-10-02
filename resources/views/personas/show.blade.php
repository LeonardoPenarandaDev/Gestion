<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                            Detalles de Persona
                        </h2>
                        <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                            Información completa del registro
                        </p>
                    </div>
                    <a href="{{ route('personas.index') }}" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;">
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
        
        .person-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 3rem;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            margin: 0 auto 1.5rem;
        }
        
        .person-info {
            text-align: center;
        }
        
        .person-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
        }
        
        .person-id {
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
        }
        
        .status-active {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border: 1px solid #86efac;
        }
        
        .status-inactive {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #fca5a5;
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
        
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .timeline-dot {
            position: absolute;
            left: -1.75rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        }
        
        .timeline-content {
            background: rgba(243, 244, 246, 0.8);
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .timeline-title {
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.25rem 0;
            font-size: 0.925rem;
        }
        
        .timeline-date {
            color: #6b7280;
            font-size: 0.8rem;
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
            <div class="person-avatar">
                @if($persona->nombre)
                    {{ strtoupper(substr($persona->nombre, 0, 1)) }}{{ strtoupper(substr(explode(' ', $persona->nombre)[1] ?? '', 0, 1)) }}
                @else
                    {{ strtoupper(substr($persona->identificacion ?? 'P', 0, 1)) }}{{ strtoupper(substr($persona->identificacion ?? 'X', -1)) }}
                @endif
            </div>
            <div class="person-info">
                <h3 class="person-name">{{ $persona->nombre ?? 'Sin nombre' }}</h3>
                <p class="person-id">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.25rem;" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    {{ $persona->identificacion ?? 'Sin identificación' }}
                </p>
                <span class="status-badge {{ ($persona->estado ?? 'Activo') === 'Activo' ? 'status-active' : 'status-inactive' }}">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.25rem;" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $persona->estado ?? 'Activo' }}
                </span>
            </div>
            
            <div class="action-buttons">
                <a href="{{ route('personas.edit', $persona) }}" class="btn-edit">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
                <form action="{{ route('personas.destroy', $persona) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar esta persona?')">
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
            <!-- Información de Contacto -->
            <div class="detail-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Información de Contacto
                    </h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Teléfono
                            </div>
                            <div class="info-value {{ $persona->telefono ? '' : 'empty' }}">
                                {{ $persona->telefono ?? 'No disponible' }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                                Email
                            </div>
                            <div class="info-value {{ $persona->email ? '' : 'empty' }}">
                                {{ $persona->email ?? 'No disponible' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0h-8m8 0h4a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h4"></path>
                                </svg>
                                Ocupación
                            </div>
                            <div class="info-value {{ $persona->ocupacion ? '' : 'empty' }}">
                                {{ $persona->ocupacion ?? 'No especificada' }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Fecha de Ingreso
                            </div>
                            <div class="info-value {{ $persona->fecha_ingreso ? '' : 'empty' }}">
                                {{ $persona->fecha_ingreso ? \Carbon\Carbon::parse($persona->fecha_ingreso)->format('d/m/Y') : 'No registrada' }}
                            </div>
                        </div>

                        @if($persona->direccion)
                        <div class="info-item" style="grid-column: span 2;">
                            <div class="info-label">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Dirección
                            </div>
                            <div class="info-value">
                                {{ $persona->direccion }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="detail-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Historial de Registro
                    </h4>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <p class="timeline-title">Registro Creado</p>
                                <p class="timeline-date">
                                    {{ $persona->created_at ? $persona->created_at->format('d/m/Y H:i') : 'Fecha desconocida' }}
                                </p>
                            </div>
                        </div>
                        
                        @if($persona->updated_at && $persona->updated_at != $persona->created_at)
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <p class="timeline-title">Última Actualización</p>
                                <p class="timeline-date">
                                    {{ $persona->updated_at->format('d/m/Y H:i') }}
                                    <span style="color: #9ca3af; margin-left: 0.5rem;">({{ $persona->updated_at->diffForHumans() }})</span>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>