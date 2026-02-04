@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#f0e6ff] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-[#C8A2C8] tracking-wide"
                style="text-shadow: 0 0 18px #C8A2C8, 0 0 40px rgba(200,162,200,0.55);">
                EDITAR HERRAMIENTA: {{ $tool->name }}
            </h1>

            <div class="relative bg-[#0f0b14]/85 backdrop-blur-lg rounded-3xl border-2 border-[#C8A2C8]/50 
                        shadow-[0_0_30px_rgba(200,162,200,0.3),inset_0_0_25px_rgba(200,162,200,0.12)]
                        p-8 md:p-12 overflow-hidden">

                <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#8A2BE2] via-50% to-[#C8A2C8] 
                            opacity-0 hover:opacity-45 transition-opacity duration-700 pointer-events-none"></div>

                <form action="{{ route('tools.update', $tool) }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Columna izquierda -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Nombre *
                                </label>
                                <input type="text" name="name" id="name"
                                       class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              placeholder-[#C8A2C8]/35 focus:outline-none focus:border-[#8A2BE2] 
                                              focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300
                                              @error('name') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror"
                                       value="{{ old('name', $tool->name) }}" required>
                                @error('name') <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Slug
                                </label>
                                <input type="text" name="slug" id="slug" readonly
                                       class="w-full bg-[#0f0b14]/70 border border-[#C8A2C8]/25 rounded-xl px-5 py-4 text-[#D4B8E8] cursor-not-allowed"
                                       value="{{ old('slug', $tool->slug) }}">
                            </div>

                            <!-- Código (readonly, no se edita) -->
                            <div>
                                <label for="code" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Código / Código de barras
                                </label>
                                <input type="text" name="code" id="code" readonly
                                       class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              cursor-not-allowed focus:outline-none"
                                       value="{{ old('code', $tool->code) }}">
                                @error('code') <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p> @enderror
                                <p class="mt-1 text-sm text-[#E3BC9A]/75 italic">El código se generó automáticamente al crear la herramienta</p>
                            </div>

                            <div>
                                <label for="category_id" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Categoría *
                                </label>
                                <select name="category_id" id="category_id"
                                        class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              focus:outline-none focus:border-[#8A2BE2] focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300
                                              @error('category_id') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror"
                                        required>
                                    <option value="">Selecciona...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $tool->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="space-y-6">
                            <div>
                                <label for="stock" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Stock actual *
                                </label>
                                <input type="number" name="stock" min="0"
                                       class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              focus:outline-none focus:border-[#8A2BE2] focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300
                                              @error('stock') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror"
                                       value="{{ old('stock', $tool->stock) }}" required>
                                @error('stock') <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Estado
                                </label>
                                <select name="status"
                                        class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              focus:outline-none focus:border-[#8A2BE2] focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300">
                                    <option value="optimo" {{ old('status', $tool->status) == 'optimo' ? 'selected' : '' }}>Óptimo</option>
                                    <option value="mantenimiento" {{ old('status', $tool->status) == 'mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                    <option value="dañado" {{ old('status', $tool->status) == 'dañado' ? 'selected' : '' }}>Dañado</option>
                                </select>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="needs_maintenance" id="needs_maintenance"
                                       class="w-5 h-5 bg-[#140d1a]/80 border-2 border-[#8A2BE2]/50 rounded 
                                              checked:bg-[#8A2BE2] checked:border-[#8A2BE2] focus:ring-[#8A2BE2]/60"
                                       {{ old('needs_maintenance', $tool->needs_maintenance) ? 'checked' : '' }}>
                                <label for="needs_maintenance" class="ml-3 text-[#E3BC9A] font-medium">
                                    Necesita mantenimiento / revisión pendiente
                                </label>
                            </div>

                            <div>
                                <label class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Imagen actual
                                </label>
                                @if ($tool->image)
                                    <div class="relative inline-block rounded-xl overflow-hidden border-2 border-[#C8A2C8]/40 
                                                shadow-[0_0_20px_rgba(200,162,200,0.25)]">
                                        <img src="{{ Storage::url($tool->image) }}" 
                                             alt="{{ $tool->name }}" 
                                             class="max-h-[180px] object-contain">
                                    </div>
                                @else
                                    <p class="text-[#E3BC9A]/70 italic">No hay imagen cargada</p>
                                @endif
                            </div>

                            <div>
                                <label for="image" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Cambiar imagen (opcional)
                                </label>
                                <input type="file" name="image" accept="image/*"
                                       class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 
                                              file:bg-[#8A2BE2]/15 file:text-[#E3BC9A] file:font-medium
                                              hover:file:bg-[#8A2BE2]/30 transition-all duration-300
                                              @error('image') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror">
                                @error('image') <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label for="notes" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                            Notas / observaciones
                        </label>
                        <textarea name="notes" rows="4"
                                  class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                        focus:outline-none focus:border-[#8A2BE2] focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300 resize-y">
                            {{ old('notes', $tool->notes) }}
                        </textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center mt-12">
                        <button type="submit"
                                class="px-10 py-5 bg-[#8A2BE2] text-white font-bold text-lg rounded-2xl 
                                       shadow-[0_0_35px_rgba(138,43,226,0.7),inset_0_0_12px_rgba(255,255,255,0.18)]
                                       hover:bg-[#9f5cf5] hover:shadow-[0_0_60px_rgba(138,43,226,0.9)] transition-all duration-400">
                            <i class="fas fa-save mr-2"></i> ACTUALIZAR HERRAMIENTA
                        </button>

                        <a href="{{ route('tools.index') }}"
                           class="px-10 py-5 border-2 border-[#C8A2C8] text-[#C8A2C8] font-bold text-lg rounded-2xl 
                                  hover:bg-[#C8A2C8]/15 hover:shadow-[0_0_45px_rgba(200,162,200,0.6)] transition-all duration-400">
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