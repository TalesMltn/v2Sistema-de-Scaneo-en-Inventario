@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#FDFDFC] to-[#f8f8f7] dark:from-[#0a0a0a] dark:to-[#111] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Tarjeta con sombra suave y borde sutil -->
            <div class="bg-white/90 dark:bg-[#161615]/90 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-[#e3e3e0]/50 dark:border-[#3E3E3A]/50 transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.15)] dark:hover:shadow-[0_20px_60px_rgba(0,0,0,0.6)]">
                <!-- Título con floritura suave -->
                <h1 class="text-4xl font-serif font-bold text-center mb-10 text-[#1b1b18] dark:text-[#EDEDEC] tracking-wide">
                    Iniciar Sesión
                </h1>

                <!-- Mensaje de error elegante -->
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-950/40 border-l-4 border-red-500 text-red-700 dark:text-red-300 px-5 py-4 rounded-lg mb-8 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/login" class="space-y-8">
                    @csrf

                    <!-- Correo -->
                    <div>
                        <label for="email" class="block text-base font-medium text-[#706f6c] dark:text-[#A1A09A] mb-3 tracking-wide">
                            Correo electrónico
                        </label>
                        <input type="email" name="email" id="email" required autofocus
                               class="w-full px-5 py-4 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-xl bg-white/70 dark:bg-[#1b1b18]/70 text-[#1b1b18] dark:text-[#EDEDEC] 
                                      focus:outline-none focus:border-[#f53003] focus:ring-2 focus:ring-[#f53003]/30 focus:bg-white dark:focus:bg-[#1b1b18] transition-all duration-300 shadow-sm"
                               value="{{ old('email') }}">
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-base font-medium text-[#706f6c] dark:text-[#A1A09A] mb-3 tracking-wide">
                            Contraseña
                        </label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-5 py-4 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-xl bg-white/70 dark:bg-[#1b1b18]/70 text-[#1b1b18] dark:text-[#EDEDEC] 
                                      focus:outline-none focus:border-[#f53003] focus:ring-2 focus:ring-[#f53003]/30 focus:bg-white dark:focus:bg-[#1b1b18] transition-all duration-300 shadow-sm">
                    </div>

                    <!-- Recordarme -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded border-[#e3e3e0] dark:border-[#3E3E3A] text-[#f53003] focus:ring-[#f53003]/30">
                        <label for="remember" class="ml-3 text-base text-[#706f6c] dark:text-[#A1A09A] select-none">
                            Recordarme
                        </label>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row gap-5 mt-10">
                        <button type="submit"
                                class="flex-1 bg-[#f53003] hover:bg-[#d92a00] text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-1">
                            Ingresar
                        </button>

                        <a href="{{ url('/') }}"
                           class="flex-1 bg-gray-100 dark:bg-[#3E3E3A] hover:bg-gray-200 dark:hover:bg-[#4a4a4a] text-[#1b1b18] dark:text-[#EDEDEC] font-semibold py-4 px-8 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl text-center transform hover:-translate-y-1">
                            Cancelar
                        </a>
                    </div>
                </form>

                <p class="text-center mt-10 text-[#706f6c] dark:text-[#A1A09A] text-sm italic">
                    ¿No tienes cuenta? Contacta al administrador.
                </p>
            </div>
        </div>
    </div>
@endsection