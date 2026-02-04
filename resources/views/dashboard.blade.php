@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#f0e6ff] font-sans">
        <div class="container mx-auto px-6 py-20 md:py-24 text-center">
            <!-- Título principal -->
            <h1 class="text-5xl md:text-6xl font-extrabold mb-6 text-[#C8A2C8] tracking-tight"
                style="text-shadow: 0 0 18px #C8A2C8, 0 0 40px rgba(200,162,200,0.55);">
                BIENVENIDO, {{ auth()->user()->name ?? 'USUARIO' }}
            </h1>

            <p class="text-xl md:text-2xl mb-16 text-[#E3BC9A] font-medium"
               style="text-shadow: 0 0 10px rgba(227,188,154,0.6);">
                SISTEMA DE INVENTARIO — ONLINE
            </p>

            <!-- Grid de tarjetas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 md:gap-12 max-w-4xl mx-auto">
                <!-- Tarjeta Herramientas -->
                <a href="{{ route('tools.index') }}"
                   class="group relative bg-[#0f0b14]/75 backdrop-blur-sm p-12 md:p-14 rounded-3xl border-2 border-[#C8A2C8]/50 overflow-hidden
                          shadow-[0_0_20px_rgba(200,162,200,0.3)] transition-all duration-400
                          hover:-translate-y-3 hover:scale-[1.03] hover:shadow-[0_0_40px_rgba(200,162,200,0.6),0_0_70px_rgba(138,43,226,0.4)]">

                    <!-- Efecto borde neón animado al hover -->
                    <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#8A2BE2] via-50% to-[#C8A2C8] opacity-0 
                                group-hover:opacity-50 transition-opacity duration-500 pointer-events-none"></div>

                    <h2 class="relative text-4xl font-black mb-5 text-[#C8A2C8] z-10"
                        style="text-shadow: 0 0 12px rgba(200,162,200,0.5);">
                        🔧 HERRAMIENTAS
                    </h2>
                    <p class="relative text-lg text-[#E3BC9A] z-10"
                       style="text-shadow: 0 0 6px rgba(227,188,154,0.4);">
                        CONTROL DE STOCK Y ESTADO
                    </p>
                </a>

                <!-- Tarjeta Categorías -->
                <a href="{{ route('categories.index') }}"
                   class="group relative bg-[#0f0b14]/75 backdrop-blur-sm p-12 md:p-14 rounded-3xl border-2 border-[#C8A2C8]/50 overflow-hidden
                          shadow-[0_0_20px_rgba(200,162,200,0.3)] transition-all duration-400
                          hover:-translate-y-3 hover:scale-[1.03] hover:shadow-[0_0_40px_rgba(200,162,200,0.6),0_0_70px_rgba(138,43,226,0.4)]">

                    <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#8A2BE2] via-50% to-[#C8A2C8] opacity-0 
                                group-hover:opacity-50 transition-opacity duration-500 pointer-events-none"></div>

                    <h2 class="relative text-4xl font-black mb-5 text-[#C8A2C8] z-10"
                        style="text-shadow: 0 0 12px rgba(200,162,200,0.5);">
                        📂 CATEGORÍAS
                    </h2>
                    <p class="relative text-lg text-[#E3BC9A] z-10"
                       style="text-shadow: 0 0 6px rgba(227,188,154,0.4);">
                        ORGANIZACIÓN DE GRUPOS
                    </p>
                </a>
            </div>

            <!-- Botón Cerrar Sesión -->
            <div class="mt-20">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                            class="relative px-14 py-5 text-xl font-bold rounded-2xl border-2 border-[#8A2BE2] text-[#8A2BE2]
                                   shadow-[0_0_25px_rgba(138,43,226,0.5),inset_0_0_12px_rgba(138,43,226,0.2)]
                                   transition-all duration-300 hover:bg-[#8A2BE2] hover:text-white
                                   hover:shadow-[0_0_50px_rgba(138,43,226,0.9)]">
                        ⏻ CERRAR SESIÓN
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection