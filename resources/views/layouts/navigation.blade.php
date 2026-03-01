<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->isTestigo() ? route('testigo.portal') : (Auth::user()->isEditor() ? route('testigos.index') : route('dashboard')) }}">
                        <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex items-center">

                    @if(Auth::user()->isTestigo())
                        <x-nav-link :href="route('testigo.portal')" :active="request()->routeIs('testigo.*')">
                            Mis Mesas
                        </x-nav-link>

                    @elseif(Auth::user()->isCoordinador())
                        <x-nav-link :href="route('testigo.portal')" :active="request()->routeIs('testigo.*')">
                            Mi Puesto
                        </x-nav-link>

                    @elseif(Auth::user()->isEditor())
                        <x-nav-link :href="route('testigos.index')" :active="request()->routeIs('testigos.*')">
                            Testigos
                        </x-nav-link>
                        <x-nav-link :href="route('coordinadores.index')" :active="request()->routeIs('coordinadores.*')">
                            Coordinadores
                        </x-nav-link>
                        <x-nav-link :href="route('resultados.index')" :active="request()->routeIs('resultados.*')">
                            Resultados
                        </x-nav-link>
                        <x-nav-link :href="route('municipios.index')" :active="request()->routeIs('municipios.*')">
                            Municipios
                        </x-nav-link>
                        <x-nav-link :href="route('actas.index')" :active="request()->routeIs('actas.*')">
                            Actas
                        </x-nav-link>

                    @else
                        {{-- ── ADMIN ── --}}

                        {{-- Dashboard --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>

                        {{-- Dropdown: Personal --}}
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open"
                                class="inline-flex items-center gap-1 px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none
                                    {{ request()->routeIs('testigos.*') || request()->routeIs('coordinadores.*')
                                        ? 'border-indigo-400 text-gray-900'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Personal
                                <svg class="w-3.5 h-3.5 opacity-60" :style="open ? 'transform:rotate(180deg)' : ''" style="transition:transform 0.15s" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute left-0 top-full mt-1 w-44 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 py-1"
                                 style="display:none;" @click="open = false">
                                <a href="{{ route('testigos.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('testigos.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : '' }}">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Testigos
                                </a>
                                <a href="{{ route('coordinadores.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('coordinadores.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : '' }}">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Coordinadores
                                </a>
                            </div>
                        </div>

                        {{-- Dropdown: Resultados --}}
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open"
                                class="inline-flex items-center gap-1 px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none
                                    {{ request()->routeIs('resultados.*') || request()->routeIs('municipios.*') || request()->routeIs('actas.*')
                                        ? 'border-indigo-400 text-gray-900'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Resultados
                                <svg class="w-3.5 h-3.5 opacity-60" :style="open ? 'transform:rotate(180deg)' : ''" style="transition:transform 0.15s" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute left-0 top-full mt-1 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 py-1"
                                 style="display:none;" @click="open = false">
                                <a href="{{ route('resultados.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('resultados.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : '' }}">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    Resultados
                                </a>
                                <a href="{{ route('municipios.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('municipios.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : '' }}">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Municipios
                                </a>
                                <a href="{{ route('actas.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('actas.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : '' }}">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Actas
                                </a>
                            </div>
                        </div>

                        {{-- Dropdown: Admin (solo admin) --}}
                        @if(Auth::user()->role === 'admin')
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open"
                                class="inline-flex items-center gap-1 px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none
                                    {{ request()->routeIs('elecciones.*') || request()->routeIs('puestos.*') || request()->routeIs('users.*')
                                        ? 'border-indigo-400 text-gray-900'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Admin
                                <svg class="w-3.5 h-3.5 opacity-60" :style="open ? 'transform:rotate(180deg)' : ''" style="transition:transform 0.15s" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute left-0 top-full mt-1 w-44 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 py-1"
                                 style="display:none;" @click="open = false">
                                <a href="{{ route('elecciones.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('elecciones.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : '' }}">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Elecciones
                                </a>
                                <a href="{{ route('puestos.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('puestos.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : '' }}">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Puestos
                                </a>
                                <div class="my-1 border-t border-gray-100"></div>
                                <a href="{{ route('users.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('users.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : '' }}">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Usuarios
                                </a>
                            </div>
                        </div>
                        @endif

                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Perfil
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (móvil) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->isTestigo())
                <x-responsive-nav-link :href="route('testigo.portal')" :active="request()->routeIs('testigo.*')">
                    Mis Mesas
                </x-responsive-nav-link>
            @elseif(Auth::user()->isCoordinador())
                <x-responsive-nav-link :href="route('testigo.portal')" :active="request()->routeIs('testigo.*')">
                    Mi Puesto
                </x-responsive-nav-link>
            @elseif(Auth::user()->isEditor())
                <x-responsive-nav-link :href="route('testigos.index')" :active="request()->routeIs('testigos.*')">
                    Testigos
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('coordinadores.index')" :active="request()->routeIs('coordinadores.*')">
                    Coordinadores
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('resultados.index')" :active="request()->routeIs('resultados.*')">
                    Resultados
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('municipios.index')" :active="request()->routeIs('municipios.*')">
                    Municipios
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('actas.index')" :active="request()->routeIs('actas.*')">
                    Actas
                </x-responsive-nav-link>
            @else
                {{-- Admin móvil --}}
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <div class="px-4 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Personal</div>
                <x-responsive-nav-link :href="route('testigos.index')" :active="request()->routeIs('testigos.*')">
                    Testigos
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('coordinadores.index')" :active="request()->routeIs('coordinadores.*')">
                    Coordinadores
                </x-responsive-nav-link>

                <div class="px-4 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Resultados</div>
                <x-responsive-nav-link :href="route('resultados.index')" :active="request()->routeIs('resultados.*')">
                    Resultados
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('municipios.index')" :active="request()->routeIs('municipios.*')">
                    Municipios
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('actas.index')" :active="request()->routeIs('actas.*')">
                    Actas
                </x-responsive-nav-link>

                @if(Auth::user()->role === 'admin')
                <div class="px-4 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</div>
                <x-responsive-nav-link :href="route('elecciones.index')" :active="request()->routeIs('elecciones.*')">
                    Elecciones
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('puestos.index')" :active="request()->routeIs('puestos.*')">
                    Puestos
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    Usuarios
                </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
