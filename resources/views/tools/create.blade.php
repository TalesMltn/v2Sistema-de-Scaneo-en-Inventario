@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#f0e6ff] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-[#C8A2C8] tracking-wide"
                style="text-shadow: 0 0 18px #C8A2C8, 0 0 40px rgba(200,162,200,0.55);">
                REGISTRAR NUEVA HERRAMIENTA
            </h1>

            <div class="relative bg-[#0f0b14]/85 backdrop-blur-lg rounded-3xl border-2 border-[#C8A2C8]/50 
                        shadow-[0_0_30px_rgba(200,162,200,0.3),inset_0_0_25px_rgba(200,162,200,0.12)]
                        p-8 md:p-12 overflow-hidden">

                <div class="absolute inset-[-2px] bg-gradient-to-r from-transparent via-[#8A2BE2] via-50% to-[#C8A2C8] 
                            opacity-0 hover:opacity-45 transition-opacity duration-700 pointer-events-none"></div>

                <form action="{{ route('tools.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Columna izquierda -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Nombre de la herramienta *
                                </label>
                                <input type="text" name="name" id="name"
                                       class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              placeholder-[#C8A2C8]/35 focus:outline-none focus:border-[#8A2BE2] 
                                              focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300
                                              @error('name') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror"
                                       value="{{ old('name') }}" required placeholder="Ej: Taladro percutor 18V">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Slug (automático)
                                </label>
                                <input type="text" name="slug" id="slug" readonly
                                       class="w-full bg-[#0f0b14]/70 border border-[#C8A2C8]/25 rounded-xl px-5 py-4 text-[#D4B8E8] cursor-not-allowed">
                                <p class="mt-1 text-sm text-[#E3BC9A]/75 italic">Se genera desde el nombre</p>
                            </div>

                            <!-- Campo Código con Generar + Previsualización -->
                            <div>
                                <label for="code" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Código / Código de barras
                                </label>
                                <div class="relative">
                                    <input type="text" name="code" id="code" readonly
                                           class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                                  cursor-not-allowed placeholder-[#C8A2C8]/35"
                                           value="{{ old('code') }}" placeholder="HR00001... (clic en Generar)">
                                    <button type="button" id="generate-code"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 px-6 py-3 bg-[#8A2BE2] text-white font-bold rounded-lg 
                                                   hover:bg-[#9f5cf5] hover:shadow-[0_0_20px_rgba(138,43,226,0.5)] transition-all duration-300">
                                        Generar
                                    </button>
                                </div>
                                @error('code')
                                    <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Previsualización del barcode -->
                            <div id="barcode-preview" class="mt-6 text-center hidden">
                                <div class="inline-block bg-white p-6 rounded-2xl shadow-[0_0_20px_rgba(200,162,200,0.3)] border-2 border-[#C8A2C8]/30">
                                    <svg id="barcode"></svg>
                                </div>
                                <p class="mt-3 text-[#E3BC9A] font-medium">Previsualización del código de barras</p>
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
                                    <option value="">Selecciona una categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="space-y-6">
                            <div>
                                <label for="stock" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Stock inicial *
                                </label>
                                <input type="number" name="stock" min="0"
                                       class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              focus:outline-none focus:border-[#8A2BE2] focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300
                                              @error('stock') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror"
                                       value="{{ old('stock', 1) }}" required>
                                @error('stock')
                                    <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Estado actual
                                </label>
                                <select name="status"
                                        class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              focus:outline-none focus:border-[#8A2BE2] focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300">
                                    <option value="optimo" {{ old('status') == 'optimo' ? 'selected' : '' }}>Óptimo</option>
                                    <option value="mantenimiento" {{ old('status') == 'mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                                    <option value="dañado" {{ old('status') == 'dañado' ? 'selected' : '' }}>Dañado</option>
                                </select>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="needs_maintenance" id="needs_maintenance"
                                       class="w-5 h-5 bg-[#140d1a]/80 border-2 border-[#8A2BE2]/50 rounded 
                                              checked:bg-[#8A2BE2] checked:border-[#8A2BE2] focus:ring-[#8A2BE2]/60"
                                       {{ old('needs_maintenance') ? 'checked' : '' }}>
                                <label for="needs_maintenance" class="ml-3 text-[#E3BC9A] font-medium">
                                    Necesita mantenimiento / revisión pendiente
                                </label>
                            </div>

                            <div>
                                <label for="image" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                                    Foto de la herramienta (opcional)
                                </label>
                                <input type="file" name="image" accept="image/*"
                                       class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                              file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 
                                              file:bg-[#8A2BE2]/15 file:text-[#E3BC9A] file:font-medium
                                              hover:file:bg-[#8A2BE2]/30 transition-all duration-300
                                              @error('image') border-red-600 shadow-[0_0_18px_rgba(220,38,38,0.5)] @enderror">
                                @error('image')
                                    <p class="mt-2 text-sm text-red-300 font-medium">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-[#E3BC9A]/70">Máx. 2MB - JPG, PNG, WEBP</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notas -->
                    <div class="mt-8">
                        <label for="notes" class="block text-lg font-semibold mb-2.5 text-[#C8A2C8] drop-shadow-[0_0_5px_#C8A2C8]">
                            Notas / observaciones
                        </label>
                        <textarea name="notes" rows="4"
                                  class="w-full bg-[#140d1a]/80 border-2 border-[#C8A2C8]/40 rounded-xl px-5 py-4 text-[#f0e6ff] 
                                        focus:outline-none focus:border-[#8A2BE2] focus:shadow-[0_0_22px_rgba(138,43,226,0.45)] transition-all duration-300 resize-y">
                            {{ old('notes') }}
                        </textarea>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row gap-5 justify-center mt-12">
                        <button type="submit"
                                class="px-10 py-5 bg-[#8A2BE2] text-white font-bold text-lg rounded-2xl 
                                       shadow-[0_0_35px_rgba(138,43,226,0.7),inset_0_0_12px_rgba(255,255,255,0.18)]
                                       hover:bg-[#9f5cf5] hover:shadow-[0_0_60px_rgba(138,43,226,0.9)] transition-all duration-400">
                            <i class="fas fa-save mr-2"></i> GUARDAR HERRAMIENTA
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

        <!-- Script slug -->
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

        <!-- Script para generar código y barcode -->
        @section('scripts')
            <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
            <script>
                document.getElementById('generate-code')?.addEventListener('click', function() {
                    // Generación simple (puedes cambiar a petición AJAX al backend después)
                    const prefix = 'HR';
                    const randomNum = Math.floor(Math.random() * 90000) + 10000; // 10000-99999
                    const code = prefix + randomNum.toString().padStart(5, '0');

                    // Poner el código en el input
                    document.getElementById('code').value = code;

                    // Mostrar barcode
                    const preview = document.getElementById('barcode-preview');
                    const barcode = document.getElementById('barcode');

                    JsBarcode("#barcode", code, {
                        format: "CODE128",
                        lineColor: "#000000",
                        width: 2.5,
                        height: 100,
                        fontSize: 20,
                        background: "#ffffff",
                        margin: 15,
                        displayValue: true
                    });

                    preview.classList.remove('hidden');
                });
            </script>
        @endsection
    </div>
@endsection