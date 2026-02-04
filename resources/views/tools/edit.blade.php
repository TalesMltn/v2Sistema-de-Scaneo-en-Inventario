@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#eaeaea] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-[#00f6ff] tracking-wide"
                style="text-shadow: 0 0 15px #00f6ff, 0 0 35px rgba(0,246,255,0.6);">
                EDITAR HERRAMIENTA: {{ $tool->name }}
            </h1>

            <div class="relative bg-[#0a0a0a]/80 backdrop-blur-md rounded-3xl border-2 border-[#00f6ff]/60 
                        shadow-[0_0_25px_rgba(0,246,255,0.35),inset_0_0_20px_rgba(0,246,255,0.15)]
                        p-8 md:p-12 overflow-hidden">

                <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#ff8c00] via-50% to-[#00f6ff] 
                            opacity-0 hover:opacity-50 transition-opacity duration-500 pointer-events-none"></div>

                <form action="{{ route('tools.update', $tool) }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Columna izquierda -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                                    Nombre *
                                </label>
                                <input type="text" name="name" id="name"
                                       class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                              placeholder-[#00f6ff]/40 focus:outline-none focus:border-[#00f6ff] 
                                              focus:shadow-[0_0_20px_rgba(0,246,255,0.5)] transition-all duration-300
                                              @error('name') border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.6)] @enderror"
                                       value="{{ old('name', $tool->name) }}" required>
                                @error('name') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                                    Slug
                                </label>
                                <input type="text" name="slug" id="slug" readonly
                                       class="w-full bg-[#0a0a0a]/60 border border-[#00f6ff]/30 rounded-xl px-5 py-4 text-[#a0f0ff] cursor-not-allowed"
                                       value="{{ old('slug', $tool->slug) }}">
                            </div>

                            <!-- Código (readonly, no se edita) -->
                            <div>
                                <label for="code" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                                    Código / Código de barras
                                </label>
                                <input type="text" name="code" id="code" readonly
                                       class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                              cursor-not-allowed focus:outline-none"
                                       value="{{ old('code', $tool->code) }}">
                                @error('code') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                                <p class="mt-1 text-sm text-[#ff9f43]/80">El código se generó automáticamente al crear la herramienta</p>
                            </div>

                            <div>
                                <label for="category_id" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                                    Categoría *
                                </label>
                                <select name="category_id" id="category_id"
                                        class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                              focus:outline-none focus:border-[#00f6ff] focus:shadow-[0_0_20px_rgba(0,246,255,0.5)] transition-all
                                              @error('category_id') border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.6)] @enderror"
                                        required>
                                    <option value="">Selecciona...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $tool->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Columna derecha (igual que antes) -->
                        <div class="space-y-6">
                            <div>
                                <label for="stock" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                                    Stock actual *
                                </label>
                                <input type="number" name="stock" min="0"
                                       class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                              focus:outline-none focus:border-[#00f6ff] focus:shadow-[0_0_20px_rgba(0,246,255,0.5)] transition-all
                                              @error('stock') border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.6)] @enderror"
                                       value="{{ old('stock', $tool->stock) }}" required>
                                @error('stock') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                                    Estado
                                </label>
                                <select name="status"
                                        class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                              focus:outline-none focus:border-[#00f6ff] focus:shadow-[0_0_20px_rgba(0,246,255,0.5)] transition-all">
                                    <option value="optimo" {{ old('status', $tool->status) == 'optimo' ? 'selected' : '' }}>Óptimo</option>
                                    <option value="mantenimiento" {{ old('status', $tool->status) == 'mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                    <option value="dañado" {{ old('status', $tool->status) == 'dañado' ? 'selected' : '' }}>Dañado</option>
                                </select>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="needs_maintenance" id="needs_maintenance"
                                       class="w-5 h-5 bg-[#111]/80 border-2 border-[#ff8c00]/60 rounded 
                                              checked:bg-[#ff8c00] checked:border-[#ff8c00] focus:ring-[#ff8c00]"
                                       {{ old('needs_maintenance', $tool->needs_maintenance) ? 'checked' : '' }}>
                                <label for="needs_maintenance" class="ml-3 text-[#ffb36b] font-medium">
                                    Necesita mantenimiento / revisión pendiente
                                </label>
                            </div>

                            <div>
                                <label class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                                    Imagen actual
                                </label>
                                @if ($tool->image)
                                    <div class="relative inline-block rounded-xl overflow-hidden border-2 border-[#00f6ff]/40 shadow-[0_0_15px_rgba(0,246,255,0.4)]">
                                        <img src="{{ Storage::url($tool->image) }}" 
                                             alt="{{ $tool->name }}" 
                                             class="max-h-[180px] object-contain">
                                    </div>
                                @else
                                    <p class="text-[#ff9f43]/70">No hay imagen cargada</p>
                                @endif
                            </div>

                            <div>
                                <label for="image" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                                    Cambiar imagen (opcional)
                                </label>
                                <input type="file" name="image" accept="image/*"
                                       class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] file:mr-4 file:py-3 file:px-6 
                                              file:rounded-lg file:border-0 file:bg-[#ff8c00]/20 file:text-[#ff8c00] file:font-semibold
                                              hover:file:bg-[#ff8c00]/40 transition-all
                                              @error('image') border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.6)] @enderror">
                                @error('image') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label for="notes" class="block text-lg font-bold mb-2 text-[#00f6ff] drop-shadow-[0_0_6px_#00f6ff]">
                            Notas / observaciones
                        </label>
                        <textarea name="notes" rows="4"
                                  class="w-full bg-[#111]/80 border-2 border-[#00f6ff]/50 rounded-xl px-5 py-4 text-[#eaeaea] 
                                        focus:outline-none focus:border-[#00f6ff] focus:shadow-[0_0_20px_rgba(0,246,255,0.5)] transition-all resize-y">
                            {{ old('notes', $tool->notes) }}
                        </textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center mt-12">
                        <button type="submit"
                                class="px-10 py-5 bg-[#ff8c00] text-black font-bold text-lg rounded-2xl 
                                       shadow-[0_0_25px_rgba(255,140,0,0.7),inset_0_0_15px_rgba(255,255,255,0.15)]
                                       hover:bg-[#ff9f43] hover:shadow-[0_0_45px_rgba(255,140,0,1)] transition-all duration-300">
                            <i class="fas fa-save mr-2"></i> ACTUALIZAR HERRAMIENTA
                        </button>

                        <a href="{{ route('tools.index') }}"
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