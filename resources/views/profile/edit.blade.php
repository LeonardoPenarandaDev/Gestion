<x-app-layout>
    {{-- Header con gradiente --}}
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    {{ __('Mi Perfil') }}
                </h2>
                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                    Administra tu información personal, contraseña y configuración de cuenta
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
        
        .profile-container {
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
        
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .profile-card {
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
        
        .card-subtitle {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0.75rem 0 0 0;
            line-height: 1.5;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 2rem;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            margin: 0 auto 1.5rem;
        }
        
        .user-info {
            text-align: center;
        }
        
        .user-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
        }
        
        .user-email {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0 0 1rem 0;
        }
        
        .user-role {
            display: inline-block;
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid #86efac;
        }
        
        .quick-stats {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        
        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            font-size: 0.875rem;
        }
        
        .stat-label {
            color: #6b7280;
        }
        
        .stat-value {
            font-weight: 600;
            color: #1f2937;
        }
        
        .nav-menu {
            margin-top: 2rem;
        }
        
        .nav-item {
            display: block;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 10px;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            text-decoration: none;
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .danger-card {
            border: 1px solid #fca5a5 !important;
            background: linear-gradient(135deg, rgba(254, 242, 242, 0.9) 0%, rgba(254, 226, 226, 0.8) 100%) !important;
        }
        
        .danger-header {
            background: linear-gradient(135deg, rgba(254, 242, 242, 0.9) 0%, rgba(254, 226, 226, 0.9) 100%) !important;
            border-bottom: 1px solid #fca5a5 !important;
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .profile-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 2rem 1rem;
            }
            
            .profile-sidebar {
                position: static;
                order: 2;
            }
            
            .profile-content {
                order: 1;
            }
        }
        
        /* Estilos para los formularios incluidos */
        .profile-card .form-group {
            margin-bottom: 1.5rem;
        }
        
        .profile-card .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .profile-card .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.925rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            color: #374151;
        }
        
        .profile-card .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }
        
        .profile-card .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.925rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .profile-card .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .profile-card .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.925rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        .profile-card .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }
        
        /* Estilos para alertas de éxito */
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border: 1px solid #86efac;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
    </style>

    <div class="profile-container fade-in">
        {{-- Sidebar --}}
        <div class="profile-sidebar">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name ?? 'U')[1] ?? '', 0, 1)) }}
            </div>
            <div class="user-info">
                <h3 class="user-name">{{ Auth::user()->name ?? 'Usuario' }}</h3>
                <p class="user-email">{{ Auth::user()->email ?? 'email@example.com' }}</p>
                <span class="user-role">Administrador</span>
            </div>
            
            <div class="quick-stats">
                <div class="stat-item">
                    <span class="stat-label">Cuenta creada</span>
                    <span class="stat-value">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : 'N/A' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Último acceso</span>
                    <span class="stat-value">{{ Auth::user()->updated_at ? Auth::user()->updated_at->diffForHumans() : 'N/A' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Verificado</span>
                    <span class="stat-value">
                        @if(Auth::user()->email_verified_at)
                            ✅ Verificado
                        @else
                            ❌ No verificado
                        @endif
                    </span>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="#profile-info" class="nav-item active">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Información Personal
                </a>
                <a href="#password-update" class="nav-item">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Cambiar Contraseña
                </a>
                <a href="#delete-account" class="nav-item" style="color: #dc2626;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.18 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Eliminar Cuenta
                </a>
            </nav>
        </div>

        {{-- Contenido Principal --}}
        <div class="profile-content">
            {{-- Información de perfil --}}
            <div class="profile-card" id="profile-info">
                <div class="card-header">
                    <h4 class="card-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información del Perfil
                    </h4>
                    <p class="card-subtitle">Actualiza la información de tu cuenta y dirección de correo electrónico. Asegúrate de mantener tus datos actualizados para una mejor experiencia.</p>
                </div>
                <div class="card-body">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Actualizar contraseña --}}
            <div class="profile-card" id="password-update">
                <div class="card-header">
                    <h4 class="card-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Actualizar Contraseña
                    </h4>
                    <p class="card-subtitle">Asegura tu cuenta usando una contraseña larga y aleatoria para mantenerte seguro. Recomendamos usar al menos 8 caracteres con mayúsculas, minúsculas, números y símbolos.</p>
                </div>
                <div class="card-body">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Eliminar cuenta --}}
            <div class="profile-card danger-card" id="delete-account">
                <div class="card-header danger-header">
                    <h4 class="card-title" style="color: #991b1b;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L4.18 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Zona de Peligro - Eliminar Cuenta
                    </h4>
                    <p class="card-subtitle" style="color: #991b1b;">Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán permanentemente borrados. Esta acción no se puede deshacer, por favor procede con precaución.</p>
                </div>
                <div class="card-body">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navegación suave
            const navItems = document.querySelectorAll('.nav-item');
            const sections = document.querySelectorAll('.profile-card');

            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remover clase active de todos
                    navItems.forEach(nav => nav.classList.remove('active'));
                    
                    // Agregar active al clickeado
                    this.classList.add('active');
                    
                    // Scroll suave al section
                    const targetId = this.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);
                    
                    if (targetSection) {
                        targetSection.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Observar qué sección está visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const activeNav = document.querySelector(`[href="#${entry.target.id}"]`);
                        if (activeNav) {
                            navItems.forEach(nav => nav.classList.remove('active'));
                            activeNav.classList.add('active');
                        }
                    }
                });
            }, {
                threshold: 0.5,
                rootMargin: '-100px 0px'
            });

            sections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>
</x-app-layout>