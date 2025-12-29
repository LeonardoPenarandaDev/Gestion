<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    {{ __('Dashboard Electoral') }}
                </h2>
                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                    Panel de Control Administrativo
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
        
        .modern-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 100%);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .counter {
            font-variant-numeric: tabular-nums;
            font-weight: bold;
            font-size: 2.5rem;
            color: #1f2937;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            margin-bottom: 0.75rem;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.8);
            color: #374151;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            color: #374151;
            text-decoration: none;
        }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .icon-blue { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .icon-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .icon-yellow { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .icon-purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            margin-top: 1rem;
        }
        
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-purple { background: #f3e8ff; color: #7c2d12; }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div style="padding: 3rem 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
            
            <!-- Tarjetas de estadísticas -->
            <div class="stats-grid fade-in">
                <!-- Personas -->
                <!--<div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div class="counter" id="counter-personas">{{ $totalPersonas ?? 0 }}</div>
                            <p style="color: #6b7280; font-size: 1.1rem; margin: 0.5rem 0 0 0;">Personas</p>
                        </div>
                        <div class="icon-circle icon-blue">
                            <svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <span class="badge badge-green">Activo</span> 
                </div>-->

                <!-- Puestos -->
                <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div class="counter" id="counter-puestos">{{ $totalPuestos ?? 0 }}</div>
                            <p style="color: #6b7280; font-size: 1.1rem; margin: 0.5rem 0 0 0;">Puestos</p>
                        </div>
                    </div>
                    <span class="badge badge-blue">Disponible</span>
                </div>

                <!--Mesas Totales -->
                <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div class="counter" id="counter-mesas">{{ $totalMesas ?? 0 }}</div>
                            <p style="color: #6b7280; font-size: 1.1rem; margin: 0.5rem 0 0 0;">Total Mesas</p>
                        </div>
                    </div>
                    <span class="badge badge-blue">Disponible</span>
                </div>

                <!--Mesas Cubiertas -->
                <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div class="counter" id="counter-mesas-cubiertas">{{ $mesasCubiertas ?? 0 }}</div>
                            <p style="color: #6b7280; font-size: 1.1rem; margin: 0.5rem 0 0 0;">Mesas Cubiertas</p>
                        </div>

                    </div>
                    <span class="badge badge-blue">Disponible</span>
                </div>

                <!-- Testigos -->
                <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div class="counter" id="counter-testigos">{{ $totalTestigos ?? 0 }}</div>
                            <p style="color: #6b7280; font-size: 1.1rem; margin: 0.5rem 0 0 0;">Testigos</p>
                        </div>
                    </div>
                    <span class="badge badge-yellow">Asignado</span>
                </div>

                <!-- Coordinadores -->
                <!-- <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div class="counter" id="counter-coordinadores">{{ $totalCoordinadores ?? 0 }}</div>
                            <p style="color: #6b7280; font-size: 1.1rem; margin: 0.5rem 0 0 0;">Coordinadores</p>
                        </div>
                        <div class="icon-circle icon-purple">
                            <svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <span class="badge badge-purple">Líder</span>
                </div>-->
            </div>

            <!-- Enlaces rápidos -->
            <div class="management-grid fade-in">
                <!-- Gestión de Personas 
                <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                        <div class="icon-circle icon-blue" style="width: 50px; height: 50px; margin-right: 1rem;">
                            <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 style="color: #1f2937; font-size: 1.25rem; font-weight: bold; margin: 0;">Gestión de Personas</h3>
                    </div>
                    
                    <div>
                        <a href="{{ route('personas.index') }}" class="btn-gradient">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Ver Todas las Personas
                        </a>
                        <a href="{{ route('personas.create') }}" class="btn-secondary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Agregar Nueva Persona
                        </a>
                    </div>
                </div>-->

                <!-- Gestión de Puestos -->
                <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                        <div class="icon-circle icon-green" style="width: 50px; height: 50px; margin-right: 1rem;">
                            <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 style="color: #1f2937; font-size: 1.25rem; font-weight: bold; margin: 0;">Gestión de Puestos</h3>
                    </div>
                    
                    <div>
                        <a href="{{ route('puestos.index') }}" class="btn-gradient">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Ver Todos los Puestos
                        </a>
                        <a href="{{ route('puestos.create') }}" class="btn-secondary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Agregar Nuevo Puesto
                        </a>
                    </div>
                </div>

                <!-- Gestión de Testigos -->
                <div class="modern-card" style="padding: 2rem;">
                    <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                        <div class="icon-circle icon-yellow" style="width: 50px; height: 50px; margin-right: 1rem;">
                            <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 style="color: #1f2937; font-size: 1.25rem; font-weight: bold; margin: 0;">Gestión de Testigos</h3>
                    </div>
                    
                    <div>
                        <a href="{{ route('testigos.index') }}" class="btn-gradient">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m13 0h-6"></path>
                            </svg>
                            Ver Todos los Testigos
                        </a>
                        <a href="{{ route('testigos.create') }}" class="btn-secondary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline; margin-right: 0.5rem;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Agregar Nuevo Testigo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de contadores
            function animateCounter(element, target) {
                let current = 0;
                const increment = Math.max(target / 100, 1);
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current).toLocaleString();
                    }
                }, 30);
            }

            // Obtener valores reales y animar
            const personas = {{ $totalPersonas ?? 0 }};
            const puestos = {{ $totalPuestos ?? 0 }};
            const totalMesas = {{ $totalMesas ?? 0 }};
            const mesasCubiertas = {{ $mesasCubiertas ?? 0 }};
            const testigos = {{ $totalTestigos ?? 0 }};
            const coordinadores = {{ $totalCoordinadores ?? 0 }};

            if (personas > 0) {
                document.getElementById('counter-personas').textContent = '0';
                setTimeout(() => animateCounter(document.getElementById('counter-personas'), personas), 200);
            }
            
            if (puestos > 0) {
                document.getElementById('counter-puestos').textContent = '0';
                setTimeout(() => animateCounter(document.getElementById('counter-puestos'), puestos), 400);
            }

            if (totalMesas > 0) {
                document.getElementById('counter-mesas').textContent = '0';
                setTimeout(() => animateCounter(document.getElementById('counter-mesas'), totalMesas), 800);
            }

            if (mesasCubiertas > 0) {
                document.getElementById('counter-mesas-cubiertas').textContent = '0';
                setTimeout(() => animateCounter(document.getElementById('counter-mesas-cubiertas'), mesasCubiertas), 800);
            }
            
            if (testigos > 0) {
                document.getElementById('counter-testigos').textContent = '0';
                setTimeout(() => animateCounter(document.getElementById('counter-testigos'), testigos), 600);
            }
            
            if (coordinadores > 0) {
                document.getElementById('counter-coordinadores').textContent = '0';
                setTimeout(() => animateCounter(document.getElementById('counter-coordinadores'), coordinadores), 800);
            }
        });
    </script>
</x-app-layout>