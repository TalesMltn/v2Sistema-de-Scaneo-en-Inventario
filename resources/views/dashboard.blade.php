@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#eaeaea] font-sans">
        <div class="container mx-auto px-6 py-20 md:py-24 text-center">
            <!-- Título principal -->
            <h1 class="text-5xl md:text-6xl font-extrabold mb-6 text-[#00f6ff] tracking-tight"
                style="text-shadow: 0 0 10px #00f6ff, 0 0 30px rgba(0,246,255,0.7);">
                BIENVENIDO, {{ auth()->user()->name ?? 'USUARIO' }}
            </h1>

            <p class="text-xl md:text-2xl mb-16 text-[#ff9f43] font-medium"
               style="text-shadow: 0 0 12px rgba(255,159,67,0.8);">
                SISTEMA DE INVENTARIO — ONLINE
            </p>

            <!-- Grid de tarjetas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 md:gap-12 max-w-4xl mx-auto">
                <!-- Tarjeta Herramientas -->
                <a href="/tools"
                   class="group relative bg-[#0a0a0a]/75 backdrop-blur-sm p-12 md:p-14 rounded-3xl border-2 border-[#00f6ff] overflow-hidden
                          shadow-[0_0_15px_rgba(0,246,255,0.4)] transition-all duration-400
                          hover:-translate-y-3 hover:scale-[1.03] hover:shadow-[0_0_35px_rgba(0,246,255,0.9),0_0_60px_rgba(255,140,0,0.7)]">

                    <!-- Efecto borde neón animado al hover -->
                    <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#ff8c00] via-50% to-[#00f6ff] opacity-0 
                                group-hover:opacity-60 transition-opacity duration-400 pointer-events-none"></div>

                    <h2 class="relative text-4xl font-black mb-5 text-[#00f6ff] z-10"
                        style="text-shadow: 0 0 12px #00f6ff;">
                        🔧 HERRAMIENTAS
                    </h2>
                    <p class="relative text-lg text-[#ffb36b] z-10"
                       style="text-shadow: 0 0 8px rgba(255,179,107,0.8);">
                        CONTROL DE STOCK Y ESTADO
                    </p>
                </a>

                <!-- Tarjeta Categorías -->
                <a href="/categories"
                   class="group relative bg-[#0a0a0a]/75 backdrop-blur-sm p-12 md:p-14 rounded-3xl border-2 border-[#00f6ff] overflow-hidden
                          shadow-[0_0_15px_rgba(0,246,255,0.4)] transition-all duration-400
                          hover:-translate-y-3 hover:scale-[1.03] hover:shadow-[0_0_35px_rgba(0,246,255,0.9),0_0_60px_rgba(255,140,0,0.7)]">

                    <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#ff8c00] via-50% to-[#00f6ff] opacity-0 
                                group-hover:opacity-60 transition-opacity duration-400 pointer-events-none"></div>

                    <h2 class="relative text-4xl font-black mb-5 text-[#00f6ff] z-10"
                        style="text-shadow: 0 0 12px #00f6ff;">
                        📂 CATEGORÍAS
                    </h2>
                    <p class="relative text-lg text-[#ffb36b] z-10"
                       style="text-shadow: 0 0 8px rgba(255,179,107,0.8);">
                        ORGANIZACIÓN DE GRUPOS
                    </p>
                </a>
            </div>

            <!-- Botón Cerrar Sesión -->
            <div class="mt-20">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                            class="relative px-14 py-5 text-xl font-bold rounded-2xl border-2 border-[#ff8c00] text-[#ff8c00]
                                   shadow-[0_0_20px_rgba(255,140,0,0.6),inset_0_0_15px_rgba(255,140,0,0.3)]
                                   transition-all duration-300 hover:bg-[#ff8c00] hover:text-black
                                   hover:shadow-[0_0_40px_rgba(255,140,0,1),0_0_80px_rgba(255,140,0,0.8)]">
                        ⏻ CERRAR SESIÓN
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection