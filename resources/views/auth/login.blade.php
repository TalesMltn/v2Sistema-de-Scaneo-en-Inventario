@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#3a2a1e] to-[#1f150e] dark:from-[#3a2a1e] dark:to-[#1f150e] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Tarjeta con sombra suave y borde sutil -->
            <div class="bg-[#3a2a1e]/90 dark:bg-[#3a2a1e]/90 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-[#A67B5B]/40 dark:border-[#A67B5B]/40 transition-all duration-500 hover:shadow-[0_20px_60px_rgba(166,123,91,0.25)] dark:hover:shadow-[0_20px_60px_rgba(166,123,91,0.5)]">
                <!-- Título con floritura suave -->
                <h1 class="text-4xl font-serif font-bold text-center mb-10 text-[#A67B5B] tracking-wide">
                    Iniciar Sesión
                </h1>

                <!-- Mensaje de error elegante -->
                @if ($errors->any())
                    <div class="bg-red-950/40 border-l-4 border-red-700 text-red-300 px-5 py-4 rounded-lg mb-8 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/login" class="space-y-8">
                    @csrf

                    <!-- Correo -->
                    <div>
                        <label for="email" class="block text-base font-medium text-[#D4A373] dark:text-[#D4A373] mb-3 tracking-wide">
                            Correo electrónico
                        </label>
                        <input type="email" name="email" id="email" required autofocus
                               class="w-full px-5 py-4 border border-[#A67B5B]/50 dark:border-[#A67B5B]/50 rounded-xl bg-[#3a2a1e]/70 dark:bg-[#3a2a1e]/70 text-[#f5e8d3] dark:text-[#f5e8d3] 
                                      focus:outline-none focus:border-[#A67B5B] focus:ring-2 focus:ring-[#A67B5B]/30 focus:bg-[#3a2a1e] dark:focus:bg-[#3a2a1e] transition-all duration-300 shadow-sm"
                               value="{{ old('email') }}">
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-base font-medium text-[#D4A373] dark:text-[#D4A373] mb-3 tracking-wide">
                            Contraseña
                        </label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-5 py-4 border border-[#A67B5B]/50 dark:border-[#A67B5B]/50 rounded-xl bg-[#3a2a1e]/70 dark:bg-[#3a2a1e]/70 text-[#f5e8d3] dark:text-[#f5e8d3] 
                                      focus:outline-none focus:border-[#A67B5B] focus:ring-2 focus:ring-[#A67B5B]/30 focus:bg-[#3a2a1e] dark:focus:bg-[#3a2a1e] transition-all duration-300 shadow-sm">
                    </div>

                    <!-- Recordarme -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded border-[#A67B5B]/50 dark:border-[#A67B5B]/50 text-[#A67B5B] focus:ring-[#A67B5B]/30">
                        <label for="remember" class="ml-3 text-base text-[#D4A373] dark:text-[#D4A373] select-none">
                            Recordarme
                        </label>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row gap-5 mt-10">
                        <button type="submit"
                                class="flex-1 bg-[#A67B5B] hover:bg-[#8B5A2B] text-[#f5e8d3] font-semibold py-4 px-8 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-1">
                            Ingresar
                        </button>

                        <a href="{{ url('/') }}"
                           class="flex-1 bg-[#3a2a1e] hover:bg-[#2a1f14] text-[#f5e8d3] font-semibold py-4 px-8 rounded-xl transition-all duration-300 shadow-md hover:shadow-xl text-center transform hover:-translate-y-1">
                            Cancelar
                        </a>
                    </div>
                </form>

                <p class="text-center mt-10 text-[#D4A373] dark:text-[#D4A373] text-sm italic">
                    ¿No tienes cuenta? Contacta al administrador.
                </p>
            </div>
        </div>
    </div>
@endsection