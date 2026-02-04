@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#eaeaea] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-[#00f6ff] tracking-wide"
                style="text-shadow: 0 0 15px #00f6ff, 0 0 35px rgba(0,246,255,0.6);">
                CREAR NUEVA CATEGORÍA
            </h1>

            <div class="relative bg-[#0a0a0a]/80 backdrop-blur-md rounded-3xl border-2 border-[#00f6ff]/60 
                        shadow-[0_0_25px_rgba(0,246,255,0.35),inset_0_0_20px_rgba(0,246,255,0.15)]
                        p-8 md:p-12 overflow-hidden">

                <!-- Efecto glow borde animado al hover -->
                <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#ff8c00] via-50% to-[#00f6ff] 
                            opacity-0 hover:opacity-50 transition-opacity duration-500 pointer-events-none"></div>

                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-8">
                    @csrf

                    <!-- Mostrar todos los errores de validación (rojo neón) -->
                    @if ($errors->any())
                        <div class="bg-red-900/50 border-l-4 border-red-500 text-red-200 p-6 rounded-2xl mb-8 shadow-[0_0_15px_rgba(239,68,68,0.4)]">
                            <strong class="block mb-2 text-lg">¡Atención! Hay errores en el formulario:</strong>
                            <ul class="list-disc pl-6 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                            Nombre de la Categoría *
                        </label>
                        <input type="text" name="name" id="name"
                               class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                      placeholder-[#00f6ff]/40 focus:outline-none focus:border-[#00f6ff] 
                                      focus:shadow-[0_0_20px_rgba(0,246,255,0.5)] transition-all duration-300
                                      @error('name') border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.6)] @enderror"
                               value="{{ old('name') }}" required placeholder="Ej: Herramientas Eléctricas">
                        @error('name')
                            <p class="mt-2 text-sm text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                            Slug (URL amigable)
                        </label>
                        <input type="text" name="slug" id="slug" readonly
                               class="w-full bg-[#0a0a0a]/60 border border-[#00f6ff]/30 rounded-xl px-5 py-4 text-[#a0f0ff] cursor-not-allowed"
                               value="{{ old('slug') }}">
                        <p class="mt-1 text-sm text-[#ff9f43]/80">Se genera automáticamente desde el nombre</p>
                    </div>

                    <div>
                        <label for="image" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                            Imagen representativa (opcional)
                        </label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp"
                               class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                      file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 
                                      file:bg-[#ff8c00]/20 file:text-[#ff8c00] file:font-semibold
                                      hover:file:bg-[#ff8c00]/40 transition-all
                                      @error('image') border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.6)] @enderror">
                        @error('image')
                            <p class="mt-2 text-sm text-red-400 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-[#ff9f43]/70">Formatos: JPG, PNG, GIF, WEBP. Máx. 2MB</p>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="active" id="active"
                               class="w-6 h-6 bg-[#111]/80 border-2 border-[#ff8c00]/60 rounded 
                                      checked:bg-[#ff8c00] checked:border-[#ff8c00] focus:ring-[#ff8c00]"
                               {{ old('active') ? 'checked' : '' }}>
                        <label for="active" class="ml-3 text-[#ffb36b] font-medium text-lg">
                            Activo – Mostrar en la página principal / bienvenida
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center mt-12">
                        <button type="submit"
                                class="px-12 py-5 bg-[#ff8c00] text-black font-bold text-xl rounded-2xl 
                                       shadow-[0_0_30px_rgba(255,140,0,0.8),inset_0_0_15px_rgba(255,255,255,0.2)]
                                       hover:bg-[#ff9f43] hover:shadow-[0_0_50px_rgba(255,140,0,1)] transition-all duration-300">
                            <i class="fas fa-save mr-3"></i> GUARDAR CATEGORÍA
                        </button>

                        <a href="{{ route('categories.index') }}"
                           class="px-12 py-5 border-2 border-[#00f6ff] text-[#00f6ff] font-bold text-xl rounded-2xl 
                                  hover:bg-[#00f6ff]/10 hover:shadow-[0_0_40px_rgba(0,246,255,0.8)] transition-all duration-300">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Script para generar slug en tiempo real -->
        <script>
            document.getElementById('name').addEventListener('input', function() {
                let name = this.value.trim();
                let slug = name.toLowerCase()
                    .replace(/[^a-z0-9áéíóúñü]+/gi, '-')
                    .replace(/á/gi, 'a')
                    .replace(/é/gi, 'e')
                    .replace(/í/gi, 'i')
                    .replace(/ó/gi, 'o')
                    .replace(/ú/gi, 'u')
                    .replace(/ñ/gi, 'n')
                    .replace(/ü/gi, 'u')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            });
        </script>
    </div>
@endsection