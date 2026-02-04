@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#f0e6ff] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-[#C8A2C8] tracking-wide"
                style="text-shadow: 0 0 18px #C8A2C8, 0 0 40px rgba(200,162,200,0.55);">
                CREAR NUEVA CATEGORÍA
            </h1>

            <div class="relative bg-[#0f0b14]/85 backdrop-blur-lg rounded-3xl border-2 border-[#C8A2C8]/50 
                        shadow-[0_0_30px_rgba(200,162,200,0.3),inset_0_0_25px_rgba(200,162,200,0.12)]
                        p-8 md:p-12 overflow-hidden">

                <!-- Glow borde animado más suave -->
                <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#8A2BE2] via-50% to-[#C8A2C8] 
                            opacity-0 hover:opacity-45 transition-opacity duration-700 pointer-events-none"></div>

                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-8">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-950/60 border-l-4 border-red-600 text-red-100 p-6 rounded-2xl mb-8 shadow-[0_0_18px_rgba(220,38,38,0.35)]">
                            <strong class="block mb-2 text-lg">Errores en el formulario:</strong>
                            <ul class="list-disc pl-6 space-y-1.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                            Nombre de la Categoría *
                        </label>
                        <input type="text" name="name" id="name"
                               class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-6 py-4 text-[#f0e6ff] 
                                      placeholder-[#C8A2C8]/35 focus:outline-none focus:border-[#8A2BE2] 
                                      focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300
                                      @error('name') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror"
                               value="{{ old('name') }}" required placeholder="Ej: Accesorios Vintage">
                        @error('name')
                            <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                            Slug (URL amigable)
                        </label>
                        <input type="text" name="slug" id="slug" readonly
                               class="w-full bg-[#0f0b14]/70 border border-[#C8A2C8]/25 rounded-xl px-6 py-4 text-[#D4B8E8] cursor-not-allowed"
                               value="{{ old('slug') }}">
                        <p class="mt-1.5 text-sm text-[#E3BC9A]/75 italic">Generado automáticamente</p>
                    </div>

                    <div>
                        <label for="image" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                            Imagen representativa (opcional)
                        </label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp"
                               class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-6 py-4 text-[#f0e6ff] 
                                      file:mr-5 file:py-3.5 file:px-7 file:rounded-xl file:border-0 
                                      file:bg-[#8A2BE2]/15 file:text-[#E3BC9A] file:font-medium
                                      hover:file:bg-[#8A2BE2]/30 transition-all duration-300
                                      @error('image') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror">
                        @error('image')
                            <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-sm text-[#E3BC9A]/70">JPG, PNG, GIF, WEBP • Máx. 2MB</p>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="active" id="active"
                               class="w-5 h-5 bg-[#140d1a]/80 border-2 border-[#8A2BE2]/50 rounded 
                                      checked:bg-[#8A2BE2] checked:border-[#8A2BE2] focus:ring-[#8A2BE2]/60"
                               {{ old('active') ? 'checked' : '' }}>
                        <label for="active" class="ml-3 text-[#E3BC9A] font-medium text-lg">
                            Activo – Visible en portada / bienvenida
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-6 justify-center mt-14">
                        <button type="submit"
                                class="px-14 py-5 bg-[#8A2BE2] text-white font-bold text-xl rounded-2xl 
                                       shadow-[0_0_35px_rgba(138,43,226,0.7),inset_0_0_12px_rgba(255,255,255,0.18)]
                                       hover:bg-[#9f5cf5] hover:shadow-[0_0_60px_rgba(138,43,226,0.9)] transition-all duration-400">
                            <i class="fas fa-save mr-3"></i> GUARDAR
                        </button>

                        <a href="{{ route('categories.index') }}"
                           class="px-14 py-5 border-2 border-[#C8A2C8] text-[#C8A2C8] font-bold text-xl rounded-2xl 
                                  hover:bg-[#C8A2C8]/15 hover:shadow-[0_0_45px_rgba(200,162,200,0.6)] transition-all duration-400">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Script slug (sin cambios) -->
        <script>
            document.getElementById('name').addEventListener('input', function() {
                let name = this.value.trim();
                let slug = name.toLowerCase()
                    .replace(/[^a-z0-9áéíóúñü]+/gi, '-')
                    .replace(/á/gi, 'a').replace(/é/gi, 'e').replace(/í/gi, 'i')
                    .replace(/ó/gi, 'o').replace(/ú/gi, 'u').replace(/ñ/gi, 'n').replace(/ü/gi, 'u')
                    .replace(/-+/g, '-').replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            });
        </script>
    </div>
@endsection