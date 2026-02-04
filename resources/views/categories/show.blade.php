@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#eaeaea] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-6 flex-wrap">
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#00f6ff] tracking-wide"
                    style="text-shadow: 0 0 15px #00f6ff, 0 0 35px rgba(0,246,255,0.6);">
                    {{ $category->name }}
                </h1>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('categories.index') }}" 
                       class="px-8 py-4 border-2 border-[#00f6ff] text-[#00f6ff] font-bold rounded-2xl 
                              hover:bg-[#00f6ff]/10 hover:shadow-[0_0_35px_rgba(0,246,255,0.7)] transition-all duration-300">
                        Volver al listado
                    </a>
                    <a href="{{ route('categories.edit', $category) }}" 
                       class="px-8 py-4 bg-[#ff8c00]/80 text-black font-bold rounded-2xl 
                              hover:bg-[#ff9f43] hover:shadow-[0_0_45px_rgba(255,140,0,0.8)] transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Imagen -->
                <div class="md:col-span-2">
                    @if ($category->image)
                        <div class="relative rounded-3xl overflow-hidden border-2 border-[#00f6ff]/50 
                                    shadow-[0_0_30px_rgba(0,246,255,0.5)]">
                            <img src="{{ Storage::url($category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-auto object-contain">
                        </div>
                    @else
                        <div class="bg-[#111]/70 border-2 border-[#00f6ff]/30 rounded-3xl h-80 flex items-center justify-center">
                            <span class="text-[#ff9f43]/70 text-2xl">Sin imagen</span>
                        </div>
                    @endif
                </div>

                <!-- Información -->
                <div class="md:col-span-3 bg-[#0a0a0a]/70 backdrop-blur-sm border-2 border-[#00f6ff]/40 
                            rounded-3xl p-8 shadow-[0_0_25px_rgba(0,246,255,0.3)]">
                    <h3 class="text-3xl font-bold text-[#00f6ff] mb-8" style="text-shadow: 0 0 12px #00f6ff;">
                        Información
                    </h3>

                    <div class="space-y-6 text-lg">
                        <div class="flex">
                            <div class="w-1/3 font-bold text-[#ff9f43]">Slug:</div>
                            <div class="w-2/3"><code class="bg-[#000]/40 px-3 py-1 rounded text-[#a0f0ff]">{{ $category->slug }}</code></div>
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-bold text-[#ff9f43]">Estado:</div>
                            <div class="w-2/3">
                                @if ($category->active)
                                    <span class="px-5 py-2 bg-green-600/40 text-green-300 rounded-full border border-green-400/30">Activo</span>
                                @else
                                    <span class="px-5 py-2 bg-gray-700/50 text-gray-300 rounded-full border border-gray-500/50">Inactivo</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col mt-8 pt-6 border-t border-[#00f6ff]/20 text-[#a0a0a0]">
                            <p><strong>Creado el:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Última actualización:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection