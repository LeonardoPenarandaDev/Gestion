<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- ── Botón flotante de WhatsApp (solo testigos y coordinadores) ── --}}
        @auth
        @if(auth()->user()->isTestigo() || auth()->user()->isCoordinador())
        @php
            $waNumero  = '573223226981'; // ← CAMBIAR por el número real (con código de país, sin + ni espacios)
            $waMensaje = urlencode('Hola, necesito ayuda con el reporte de mi mesa en el sistema electoral.');
            $waUrl     = "https://wa.me/{$waNumero}?text={$waMensaje}";
        @endphp
        <a href="{{ $waUrl }}" target="_blank" rel="noopener"
           title="¿Necesitas ayuda? Escríbenos por WhatsApp"
           style="
               position: fixed;
               bottom: 1.5rem;
               left: 1.5rem;
               z-index: 9990;
               display: flex;
               align-items: center;
               gap: 0.6rem;
               background: #25d366;
               color: white;
               text-decoration: none;
               padding: 0.7rem 1.1rem 0.7rem 0.85rem;
               border-radius: 50px;
               box-shadow: 0 4px 18px rgba(37,211,102,0.45);
               font-family: 'Inter', sans-serif;
               font-weight: 700;
               font-size: 0.875rem;
               transition: transform 0.2s, box-shadow 0.2s;
               white-space: nowrap;
           "
           onmouseover="this.style.transform='scale(1.06)';this.style.boxShadow='0 6px 24px rgba(37,211,102,0.55)'"
           onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 18px rgba(37,211,102,0.45)'">
            {{-- Ícono WhatsApp SVG --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                 style="width:1.5rem;height:1.5rem;flex-shrink:0;" fill="white">
                <path d="M16 0C7.163 0 0 7.163 0 16c0 2.822.738 5.469 2.031 7.769L0 32l8.469-2.007A15.93 15.93 0 0016 32c8.837 0 16-7.163 16-16S24.837 0 16 0zm0 29.333a13.27 13.27 0 01-6.771-1.849l-.485-.289-5.025 1.191 1.213-4.895-.316-.502A13.267 13.267 0 012.667 16C2.667 8.636 8.636 2.667 16 2.667S29.333 8.636 29.333 16 23.364 29.333 16 29.333zm7.273-9.878c-.398-.199-2.358-1.163-2.723-1.296-.365-.133-.631-.199-.897.199-.266.398-1.031 1.296-1.264 1.562-.233.266-.465.299-.863.1-.398-.199-1.681-.619-3.202-1.977-1.183-1.056-1.982-2.361-2.214-2.759-.232-.398-.025-.613.175-.811.179-.178.398-.465.597-.698.199-.233.266-.398.398-.664.133-.266.067-.498-.033-.697-.1-.199-.897-2.162-1.23-2.96-.324-.778-.653-.673-.897-.685l-.764-.013c-.266 0-.697.1-1.063.498-.365.398-1.396 1.363-1.396 3.325s1.429 3.858 1.628 4.124c.199.266 2.812 4.294 6.814 6.022.952.411 1.695.656 2.274.840.955.304 1.824.261 2.511.158.766-.115 2.358-.964 2.69-1.895.333-.931.333-1.729.233-1.895-.099-.166-.365-.265-.763-.464z"/>
            </svg>
            <span>¿Necesitas ayuda?</span>
        </a>
        @endif
        @endauth
    </body>
</html>
