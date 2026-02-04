@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#eaeaea] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-[#00f6ff] tracking-wide"
                style="text-shadow: 0 0 15px #00f6ff, 0 0 35px rgba(0,246,255,0.6);">
                EDITAR CATEGORÍA: {{ $category->name }}
            </h1>

            <div class="relative bg-[#0a0a0a]/80 backdrop-blur-md rounded-3xl border-2 border-[#00f6ff]/60 
                        shadow-[0_0_25px_rgba(0,246,255,0.35),inset_0_0_20px_rgba(0,246,255,0.15)]
                        p-8 md:p-12 overflow-hidden">

                <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#ff8c00] via-50% to-[#00f6ff] 
                            opacity-0 hover:opacity-50 transition-opacity duration-500 pointer-events-none"></div>

                <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-8">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                            Nombre de la Categoría *
                        </label>
                        <input type="text" name="name" id="name"
                               class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                      focus:outline-none focus:border-[#00f6ff] focus:shadow-[0_0_20px_rgba(0,246,255,0.5)] transition-all
                                      @error('name') border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.6)] @enderror"
                               value="{{ old('name', $category->name) }}" required>
                        @error('name') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                            Slug
                        </label>
                        <input type="text" name="slug" id="slug" readonly
                               class="w-full bg-[#0a0a0a]/60 border border-[#00f6ff]/30 rounded-xl px-5 py-4 text-[#a0f0ff] cursor-not-allowed"
                               value="{{ old('slug', $category->slug) }}">
                    </div>

                    <div>
                        <label class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                            Imagen actual
                        </label>
                        @if ($category->image)
                            <div class="relative inline-block rounded-xl overflow-hidden border-2 border-[#00f6ff]/40 shadow-[0_0_15px_rgba(0,246,255,0.4)]">
                                <img src="{{ Storage::url($category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="max-h-[180px] object-contain">
                            </div>
                        @else
                            <p class="text-[#ff9f43]/70">No hay imagen cargada actualmente.</p>
                        @endif
                    </div>

                    <div>
                        <label for="image" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                            Cambiar imagen (opcional)
                        </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] file:mr-4 file:py-3 file:px-6 
                                      file:rounded-lg file:border-0 file:bg-[#ff8c00]/20 file:text-[#ff8c00] file:font-semibold
                                      hover:file:bg-[#ff8c00]/40 transition-all
                                      @error('image') border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.6)] @enderror">
                        @error('image') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="active" id="active"
                               class="w-5 h-5 bg-[#111]/80 border-2 border-[#ff8c00]/60 rounded 
                                      checked:bg-[#ff8c00] checked:border-[#ff8c00] focus:ring-[#ff8c00]"
                               {{ old('active', $category->active ? 'checked' : '') }}>
                        <label for="active" class="ml-3 text-[#ffb36b] font-medium text-lg">
                            Activo – Mostrar en la página principal
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center mt-10">
                        <button type="submit"
                                class="px-10 py-5 bg-[#ff8c00] text-black font-bold text-lg rounded-2xl 
                                       shadow-[0_0_25px_rgba(255,140,0,0.7),inset_0_0_15px_rgba(255,255,255,0.15)]
                                       hover:bg-[#ff9f43] hover:shadow-[0_0_45px_rgba(255,140,0,1)] transition-all duration-300">
                            <i class="fas fa-save mr-2"></i> ACTUALIZAR CATEGORÍA
                        </button>

                        <a href="{{ route('categories.index') }}"
                           class="px-10 py-5 border-2 border-[#00f6ff] text-[#00f6ff] font-bold text-lg rounded-2xl 
                                  hover:bg-[#00f6ff]/10 hover:shadow-[0_0_35px_rgba(0,246,255,0.7)] transition-all duration-300">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('name').addEventListener('input', function() {
                let name = this.value.trim();
                let slug = name.toLowerCase()
                    .replace(/[^a-z0-9áéíóúñü]+/gi, '-')
                    .replace(/á/gi, 'a').replace(/é/gi, 'e').replace(/í/gi, 'i')
                    .replace(/ó/gi, 'o').replace(/ú/gi, 'u').replace(/ñ/gi, 'n').replace(/ü/gi, 'u')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            });
        </script>
    </div>
@endsection