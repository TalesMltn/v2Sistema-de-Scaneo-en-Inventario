<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Taller - Escaneo de Inventario</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Estilos neón suaves y cyberpunk -->
    <style>
        :root {
            --cyan-neon: #A67B5B;
            --orange-neon: #8B5A2B;
            --orange-light: #A67B5B;
            --bg-dark: #3a2a1e;
            --card-dark: #2a1f14;
            --text-light: #f5e8d3;
            --gray-light: #D4A373;
        }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: radial-gradient(circle at top, #3a2a1e, #1f150e);
        }
        .neon-title {
            text-shadow: 0 0 10px var(--cyan-neon), 0 0 20px var(--cyan-neon), 0 0 30px rgba(166,123,91,0.5);
        }
        .neon-button {
            box-shadow: 0 0 15px rgba(139,90,43,0.5), inset 0 0 10px rgba(139,90,43,0.3);
        }
        .neon-button:hover {
            box-shadow: 0 0 30px rgba(139,90,43,0.8), inset 0 0 15px rgba(139,90,43,0.5);
        }

        /* Efecto 3D + salto al hover */
        .tool-card {
            perspective: 1000px;
            transition: transform 0.4s ease-out;
        }

        .tool-card:hover {
            transform: translateY(-12px) rotateX(6deg) rotateY(8deg);
            box-shadow: 0 25px 50px -12px rgba(166,123,91,0.5);
        }

        .tool-card .image-wrapper {
            transition: transform 0.5s ease-out;
            transform-style: preserve-3d;
        }

        .tool-card:hover .image-wrapper {
            transform: translateZ(30px) scale(1.08);
        }

        .tool-card img,
        .tool-card .placeholder-img {
            transition: transform 0.5s ease-out;
        }

        .tool-card:hover img,
        .tool-card:hover .placeholder-img {
            transform: scale(1.12) translateZ(40px);
        }

        .card-glow {
            box-shadow: 0 0 20px rgba(166,123,91,0.3), inset 0 0 15px rgba(166,123,91,0.1);
        }
        .card-glow:hover {
            box-shadow: 0 0 35px rgba(166,123,91,0.5), inset 0 0 20px rgba(166,123,91,0.2);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-[#f5e8d3] antialiased">

    <!-- Header con botón de login -->
    <header class="w-full py-6 px-6 lg:px-12 flex justify-between items-center border-b border-[#A67B5B]/20 bg-[#3a2a1e]/70 backdrop-blur-md sticky top-0 z-50">
        <div class="text-3xl font-bold neon-title flex items-center gap-3">
            <i class="fas fa-tools text-[#8B5A2B]"></i>
            Inventario Huancayo
        </div>

        <div>
            <a href="/login"
               class="px-8 py-3 bg-[var(--orange-neon)] hover:bg-[var(--orange-light)] text-black font-semibold rounded-xl shadow-lg neon-button transition-all duration-300 text-lg flex items-center gap-2">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="flex-grow flex flex-col items-center justify-center py-16 px-6 lg:px-12">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Título principal más pequeño como pediste -->
            <h1 class="text-3xl lg:text-5xl font-extrabold mb-6 neon-title leading-tight">
                Sistema de Escaneo e Inventario
            </h1>
        </div>

        <!-- Herramientas destacadas -->
        @php
            $tools = \App\Models\Tool::with('category')->where('stock', '>', 0)->latest()->take(12)->get();
        @endphp

        @if ($tools->isNotEmpty())
            <div class="w-full mt-10">
                <!-- Título grande y destacado: Herramientas Disponibles -->
                <h2 class="text-4xl lg:text-6xl font-extrabold text-center mb-12 neon-title">
                    Herramientas Disponibles
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($tools as $tool)
                        <div class="tool-card bg-[#2a1f14]/80 backdrop-blur-md rounded-2xl overflow-hidden border border-[#A67B5B]/20">
                            <div class="image-wrapper">
                                @if ($tool->image)
                                    <img src="{{ Storage::url($tool->image) }}" 
                                         alt="{{ $tool->name }}" 
                                         class="w-full h-56 object-cover">
                                @else
                                    <div class="w-full h-56 bg-gradient-to-br from-[#2a1f14] to-[#1f150e] flex items-center justify-center placeholder-img">
                                        <i class="fas fa-tools text-7xl text-[#A67B5B]/30"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6 text-center">
                                <h3 class="text-2xl font-bold mb-2 neon-cyan">
                                    {{ $tool->name }}
                                </h3>
                                <p class="text-sm text-[#D4A373] mb-1">
                                    {{ $tool->code ?? 'Sin código' }}
                                </p>
                                <p class="text-base text-[#D4A373] mb-3">
                                    {{ $tool->category?->name ?? 'Sin categoría' }}
                                </p>

                                <div class="flex justify-center gap-6 text-sm">
                                    <div>
                                        <span class="font-bold text-[#A67B5B]">Stock:</span> {{ $tool->stock }}
                                    </div>
                                    <div>
                                        @if ($tool->status === 'optimo')
                                            <span class="text-green-400 font-bold">Óptimo</span>
                                        @elseif ($tool->status === 'mantenimiento')
                                            <span class="text-yellow-400 font-bold">Mantenimiento</span>
                                        @else
                                            <span class="text-red-400 font-bold">Dañado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12">

                </div>
            </div>
        @else
            <div class="text-center py-20 mt-12">
                <i class="fas fa-tools text-9xl text-[#A67B5B]/30 mb-8"></i>
                <p class="text-3xl font-semibold text-[#D4A373]">
                    Aún no hay herramientas registradas.
                </p>
                <p class="text-xl mt-6 text-[#D4A373]">
                    Inicia sesión para comenzar a gestionar tu inventario.
                </p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="py-10 text-center text-base text-[#D4A373] border-t border-[#A67B5B]/20 bg-[#3a2a1e]/70 backdrop-blur-md">
        <p>© {{ now()->year }} Inventario Huancayo • Proyecto Escaneo Inventario • Junín, Perú</p>
    </footer>

</body>
</html>