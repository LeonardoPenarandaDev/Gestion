<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    {{ __('Gestión de Testigos') }}
                </h2>
                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                    Administra los testigos electorales del sistema
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
        
        .header-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding: 2rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .modern-table th {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #374151;
            font-weight: 600;
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .modern-table th:first-child {
            border-top-left-radius: 12px;
        }
        
        .modern-table th:last-child {
            border-top-right-radius: 12px;
        }
        
        .modern-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            color: #374151;
            font-weight: 500;
        }
        
        .modern-table tr {
            transition: all 0.2s ease;
        }
        
        .modern-table tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            transform: scale(1.005);
        }
        
        .modern-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px;
        }
        
        .modern-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px;
        }
        
        .testigo-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .testigo-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .testigo-info h4 {
            margin: 0;
            font-weight: 600;
            color: #1f2937;
            font-size: 0.95rem;
        }
        
        .testigo-info p {
            margin: 0.25rem 0 0 0;
            font-size: 0.825rem;
            color: #6b7280;
        }
        
        .zone-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0369a1;
            border: 1px solid #7dd3fc;
        }
        
        .puesto-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #166534;
            border: 1px solid #86efac;
        }
        
        .mesa-count {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #fbbf24;
        }
        
        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
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
        
        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-right: 0.5rem;
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
        }
        
        .btn-view {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0369a1;
            border: 1px solid #7dd3fc;
        }
        
        .btn-view:hover {
            background: linear-gradient(135deg, #bae6fd 0%, #93c5fd 100%);
            transform: translateY(-1px);
            color: #0369a1;
            text-decoration: none;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #fbbf24;
        }
        
        .btn-edit:hover {
            background: linear-gradient(135deg, #fde68a 0%, #fcd34d 100%);
            transform: translateY(-1px);
            color: #92400e;
            text-decoration: none;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #fca5a5;
            cursor: pointer;
        }
        
        .btn-delete:hover {
            background: linear-gradient(135deg, #fecaca 0%, #f87171 100%);
            transform: translateY(-1px);
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }
        
        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .table-container {
            padding: 2rem;
            overflow-x: auto;
        }
        
        .location-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .location-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.9rem;
        }
        
        .location-address {
            font-size: 0.8rem;
            color: #6b7280;
            display: flex;
            align-items: center;
        }
        
        .stats-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        
        .stat-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            flex: 1;
            min-width: 200px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }
        
        @media (max-width: 768px) {
            .modern-table th,
            .modern-table td {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            .action-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
                margin-bottom: 0.25rem;
            }
            
            .testigo-card {
                gap: 0.5rem;
            }
            
            .testigo-avatar {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }
        }
    </style>

    <div style="padding: 3rem 0;">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 1.5rem;">
            <div class="modern-container fade-in">
                <!-- Header Section -->
                <div class="header-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.5rem; font-weight: 700; margin: 0; color: #1f2937;">Lista de Testigos</h3>
                            <p style="color: #6b7280; margin: 0.5rem 0 0 0;">Administra y visualiza todos los testigos electorales</p>
                        </div>
                        <a href="{{ route('testigos.create') }}" class="btn-primary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nuevo Testigo
                        </a>
                    </div>
                </div>

                <!-- Stats Section -->
                @if(isset($testigos) && $testigos->count() > 0)
                <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <div class="stats-row">
                        <div class="stat-card">
                            <div class="stat-number">{{ $testigos->count() }}</div>
                            <div class="stat-label">Total Testigos</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $testigos->count() }}</div>
                            <div class="stat-label">Mesas Cubiertas</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $testigos->pluck('fk_id_zona')->unique()->count() }}</div>
                            <div class="stat-label">Zonas Activas</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $testigos->pluck('fk_id_puesto')->unique()->count() }}</div>
                            <div class="stat-label">Puestos Cubiertos</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Table Section -->
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>
                                    <div style="display: flex; align-items: center;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Testigo
                                    </div>
                                </th>
                                <th>
                                    <div style="display: flex; align-items: center;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Zona
                                    </div>
                                </th>
                                <th>
                                    <div style="display: flex; align-items: center;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Puesto Asignado
                                    </div>
                                </th>
                                <th>
                                    <div style="display: flex; align-items: center;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Mesas
                                    </div>
                                </th>
                                <th>
                                    <div style="display: flex; align-items: center;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Estado
                                    </div>
                                </th>
                                <th>
                                    <div style="display: flex; align-items: center;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                        Acciones
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testigos ?? [] as $testigo)
                            <tr>
                                <td>
                                    <div class="testigo-card">
                                        <div class="testigo-avatar">
                                            {{ strtoupper(substr($testigo->nombre ?? 'T', 0, 1)) }}{{ strtoupper(substr(explode(' ', $testigo->nombre ?? 'T')[1] ?? '', 0, 1)) }}
                                        </div>
                                        <div class="testigo-info">
                                            <h4>{{ $testigo->nombre ?? 'Sin nombre' }}</h4>
                                            <p>
                                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                                {{ $testigo->documento ?? 'Sin documento' }}
                                                @if($testigo->alias)
                                                    • "{{ $testigo->alias }}"
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="zone-badge">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                         Zona {{ $testigo->fk_id_zona ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="location-info">
                                        <span class="puesto-badge">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ $testigo->puesto->puesto ?? 'N/A' }}
                                        </span>
                                        @if($testigo->puesto)
                                        <div class="location-address">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ Str::limit($testigo->puesto->nombre ?? '', 25) }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="mesa-count">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Mesa {{ $testigo->mesas ?? '0' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-active">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Activo
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                        <a href="{{ route('testigos.show', $testigo) }}" class="action-btn btn-view">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </a>
                                        <a href="{{ route('testigos.edit', $testigo) }}" class="action-btn btn-edit">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('testigos.destroy', $testigo) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete" onclick="return confirm('¿Está seguro de eliminar este testigo?')">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.25rem;" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color: #9ca3af;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                                            </svg>
                                        </div>
                                        <h4 style="font-size: 1.25rem; font-weight: 600; margin: 0 0 0.5rem 0; color: #374151;">No hay testigos registrados</h4>
                                        <p style="color: #6b7280; margin: 0 0 1.5rem 0;">Comienza agregando el primer testigo electoral al sistema</p>
                                        <a href="{{ route('testigos.create') }}" class="btn-primary">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Agregar Primer Testigo
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($testigos) && method_exists($testigos, 'hasPages') && $testigos->hasPages())
                <div style="padding: 1.5rem 2rem; border-top: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.8) 100%);">
                    {{ $testigos->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar tooltip con información completa del testigo
            const testigoCards = document.querySelectorAll('.testigo-card');
            
            testigoCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    const avatar = this.querySelector('.testigo-avatar');
                    if (avatar) {
                        avatar.style.transform = 'scale(1.1)';
                        avatar.style.boxShadow = '0 6px 20px rgba(102, 126, 234, 0.4)';
                    }
                });
                
                card.addEventListener('mouseleave', function() {
                    const avatar = this.querySelector('.testigo-avatar');
                    if (avatar) {
                        avatar.style.transform = 'scale(1)';
                        avatar.style.boxShadow = '0 4px 12px rgba(102, 126, 234, 0.3)';
                    }
                });
            });

            // Filtrar testigos en tiempo real
            function addSearchFunctionality() {
                const searchInput = document.createElement('input');
                searchInput.type = 'text';
                searchInput.placeholder = 'Buscar testigos...';
                searchInput.style.cssText = `
                    width: 300px;
                    padding: 0.75rem 1rem;
                    border: 2px solid #e5e7eb;
                    border-radius: 12px;
                    font-size: 0.925rem;
                    background: rgba(255, 255, 255, 0.8);
                    backdrop-filter: blur(5px);
                `;
                
                const headerDiv = document.querySelector('.header-section > div');
                if (headerDiv) {
                    const searchContainer = document.createElement('div');
                    searchContainer.style.cssText = 'display: flex; align-items: center; gap: 1rem;';
                    
                    const newButton = headerDiv.querySelector('.btn-primary');
                    searchContainer.appendChild(searchInput);
                    searchContainer.appendChild(newButton);
                    
                    headerDiv.appendChild(searchContainer);
                    
                    // Funcionalidad de búsqueda
                    searchInput.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();
                        const rows = document.querySelectorAll('tbody tr:not(.empty-row)');
                        
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            if (text.includes(searchTerm)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });
                }
            }

            // Solo agregar búsqueda si hay testigos
            const tbody = document.querySelector('tbody');
            const hasTestigos = tbody && tbody.children.length > 0 && !tbody.querySelector('.empty-state');
            
            if (hasTestigos) {
                addSearchFunctionality();
            }

            // Animación de las estadísticas
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach((stat, index) => {
                const target = parseInt(stat.textContent);
                if (target > 0) {
                    stat.textContent = '0';
                    setTimeout(() => {
                        animateNumber(stat, target);
                    }, index * 200);
                }
            });
            
            function animateNumber(element, target) {
                let current = 0;
                const increment = Math.max(Math.ceil(target / 30), 1);
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = target;
                        clearInterval(timer);
                    } else {
                        element.textContent = current;
                    }
                }, 50);
            }
        });
    </script>
</x-app-layout>