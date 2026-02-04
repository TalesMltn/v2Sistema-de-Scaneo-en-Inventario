@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#f0e6ff] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-6 flex-wrap">
                <h1 class="text-4xl md:text-5xl font-extrabold text-center text-[#C8A2C8] tracking-wide"
                    style="text-shadow: 0 0 18px #C8A2C8, 0 0 40px rgba(200,162,200,0.55);">
                    {{ $category->name }}
                </h1>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('categories.index') }}" 
                       class="px-8 py-4 border-2 border-[#C8A2C8] text-[#C8A2C8] font-bold rounded-2xl 
                              hover:bg-[#C8A2C8]/15 hover:shadow-[0_0_35px_rgba(200,162,200,0.6)] transition-all duration-300">
                        Volver al listado
                    </a>
                    <a href="{{ route('categories.edit', $category) }}" 
                       class="px-8 py-4 bg-[#8A2BE2] text-white font-bold rounded-2xl 
                              hover:bg-[#9f5cf5] hover:shadow-[0_0_50px_rgba(138,43,226,0.8)] transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Imagen -->
                <div class="md:col-span-2">
                    @if ($category->image)
                        <div class="relative rounded-3xl overflow-hidden border-2 border-[#C8A2C8]/50 
                                    shadow-[0_0_30px_rgba(200,162,200,0.35)]">
                            <img src="{{ Storage::url($category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-auto object-contain">
                        </div>
                    @else
                        <div class="bg-[#140d1a]/70 border-2 border-[#C8A2C8]/40 rounded-3xl h-80 flex items-center justify-center">
                            <span class="text-[#E3BC9A]/70 text-2xl italic">Sin imagen</span>
                        </div>
                    @endif
                </div>

                <!-- Información -->
                <div class="md:col-span-3 bg-[#0f0b14]/70 backdrop-blur-sm border-2 border-[#C8A2C8]/40 
                            rounded-3xl p-8 shadow-[0_0_25px_rgba(200,162,200,0.25)]">
                    <h3 class="text-3xl font-bold text-[#C8A2C8] mb-8" style="text-shadow: 0 0 12px rgba(200,162,200,0.4);">
                        Información
                    </h3>

                    <div class="space-y-6 text-lg">
                        <div class="flex items-center">
                            <div class="w-1/3 font-semibold text-[#E3BC9A]">Slug:</div>
                            <div class="w-2/3">
                                <code class="bg-[#0f0b14]/60 px-3 py-1 rounded text-[#D4B8E8] font-mono">
                                    {{ $category->slug }}
                                </code>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-1/3 font-semibold text-[#E3BC9A]">Estado:</div>
                            <div class="w-2/3">
                                @if ($category->active)
                                    <span class="px-5 py-2 bg-[#8A2BE2]/20 text-[#D4B8E8] rounded-full border border-[#8A2BE2]/40 font-medium">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-5 py-2 bg-gray-800/50 text-gray-400 rounded-full border border-gray-600/50 font-medium">
                                        Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col mt-8 pt-6 border-t border-[#C8A2C8]/20 text-[#D4B8E8]/90">
                            <p><strong>Creado el:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Última actualización:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection