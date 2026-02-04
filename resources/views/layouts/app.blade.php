<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventario Huancayo') }}</title>

    <!-- Tailwind CSS (CDN para desarrollo rápido) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome 6 (para iconos fa-eye, fa-edit, fa-trash, fa-plus, etc.) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- JsBarcode para generar códigos de barras en el frontend (necesario para tools/create y edit) -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

    <!-- Google Fonts (fuentes cyberpunk/modernas) -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto+Mono&display=swap" rel="stylesheet">

    <!-- Tus estilos personalizados o por página -->
    @yield('styles')

    <!-- Estilos globales neón -->
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
        }
        h1, h2, h3 {
            font-family: 'Orbitron', sans-serif;
        }
        .neon-cyan {
            text-shadow: 0 0 10px #F5E8D3, 0 0 20px #F5E8D3, 0 0 30px #F5E8D3;
        }
        .neon-orange {
            text-shadow: 0 0 10px #E8C39E, 0 0 20px #E8C39E, 0 0 30px #E8C39E;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-[#3a2f24] to-[#251e16] text-[#f5f0e8] min-h-screen antialiased flex flex-col">

    <!-- Header / Navbar simple con estilo neón -->
    <header class="bg-[#3a2f24]/80 backdrop-blur-md border-b-2 border-[#F5E8D3]/40 shadow-[0_0_20px_rgba(245,232,211,0.25)] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold neon-cyan">
                <i class="fas fa-robot mr-2"></i> EscaneoInventario
            </a>

            @auth
                <div class="flex items-center gap-6">
                    <span class="text-[#E8C39E] hidden sm:inline">
                        Bienvenido, {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-5 py-2 bg-red-950/40 text-red-300 rounded-lg hover:bg-red-900/60 hover:shadow-[0_0_15px_rgba(220,38,38,0.5)] transition-all">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 border-2 border-[#F5E8D3] text-[#F5E8D3] rounded-lg hover:bg-[#F5E8D3]/15">
                    Iniciar Sesión
                </a>
            @endauth
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer opcional -->
    <footer class="bg-[#3a2f24]/90 border-t-2 border-[#F5E8D3]/30 py-6 text-center text-sm text-[#E8C39E]">
        <p>© {{ date('Y') }} Inventario Huancayo - Sistema de Gestión</p>
    </footer>

    <!-- Scripts globales -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Scripts por página -->
    @yield('scripts')
</body>
</html>