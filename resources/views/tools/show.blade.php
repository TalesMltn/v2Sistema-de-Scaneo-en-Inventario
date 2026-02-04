@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#f0e6ff] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-6 flex-wrap">
                <h1 class="text-4xl md:text-5xl font-extrabold text-center text-[#C8A2C8] tracking-wide"
                    style="text-shadow: 0 0 18px #C8A2C8, 0 0 40px rgba(200,162,200,0.55);">
                    {{ $tool->name }}
                </h1>

                <div class="flex gap-4">
                    <a href="{{ route('tools.index') }}" 
                       class="px-8 py-4 border-2 border-[#C8A2C8] text-[#C8A2C8] font-bold rounded-2xl 
                              hover:bg-[#C8A2C8]/15 hover:shadow-[0_0_35px_rgba(200,162,200,0.6)] transition-all duration-300">
                        Volver al listado
                    </a>
                    <a href="{{ route('tools.edit', $tool) }}" 
                       class="px-8 py-4 bg-[#8A2BE2] text-white font-bold rounded-2xl 
                              hover:bg-[#9f5cf5] hover:shadow-[0_0_50px_rgba(138,43,226,0.8)] transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Imagen -->
                <div class="md:col-span-2">
                    @if ($tool->image)
                        <div class="relative rounded-3xl overflow-hidden border-2 border-[#C8A2C8]/50 
                                    shadow-[0_0_30px_rgba(200,162,200,0.35)]">
                            <img src="{{ Storage::url($tool->image) }}" 
                                 alt="{{ $tool->name }}" 
                                 class="w-full h-auto object-contain">
                        </div>
                    @else
                        <div class="bg-[#140d1a]/70 border-2 border-[#C8A2C8]/40 rounded-3xl h-80 flex items-center justify-center">
                            <span class="text-[#E3BC9A]/70 text-2xl italic">Sin imagen</span>
                        </div>
                    @endif
                </div>

                <!-- Detalles -->
                <div class="md:col-span-3 bg-[#0f0b14]/70 backdrop-blur-sm border-2 border-[#C8A2C8]/40 
                            rounded-3xl p-8 shadow-[0_0_25px_rgba(200,162,200,0.25)]">
                    <h3 class="text-3xl font-bold text-[#C8A2C8] mb-8" style="text-shadow: 0 0 12px rgba(200,162,200,0.4);">
                        Detalles
                    </h3>

                    <div class="space-y-6 text-lg">
                        <div class="flex flex-col items-center md:items-start">
                            <div class="w-full md:w-auto font-semibold text-[#E3BC9A] mb-2">Código:</div>
                            <div class="text-3xl font-bold text-[#D4B8E8] mb-4">{{ $tool->code ?? 'No asignado' }}</div>
                            <!-- Código de barras grande -->
                            @if ($tool->code)
                                <div id="barcode-show" class="bg-white p-6 rounded-2xl shadow-[0_0_20px_rgba(200,162,200,0.3)] border-2 border-[#C8A2C8]/30">
                                    <svg id="barcode-large"></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-semibold text-[#E3BC9A]">Categoría:</div>
                            <div class="w-2/3">{{ $tool->category?->name ?? 'Sin categoría' }}</div>
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-semibold text-[#E3BC9A]">Stock actual:</div>
                            <div class="w-2/3 flex items-center gap-3">
                                <span class="text-2xl font-bold">{{ $tool->stock }}</span>
                                @if ($tool->stock <= 0)
                                    <span class="px-4 py-1 bg-red-900/50 text-red-200 rounded-full border border-red-600/40">Sin stock</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-semibold text-[#E3BC9A]">Estado:</div>
                            <div class="w-2/3">
                                @if ($tool->status === 'optimo')
                                    <span class="px-5 py-2 bg-green-700/30 text-green-300 rounded-full border border-green-500/40">Óptimo</span>
                                @elseif ($tool->status === 'mantenimiento')
                                    <span class="px-5 py-2 bg-yellow-700/30 text-yellow-300 rounded-full border border-yellow-500/40">En mantenimiento</span>
                                @else
                                    <span class="px-5 py-2 bg-red-900/40 text-red-300 rounded-full border border-red-600/40">Dañado</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-semibold text-[#E3BC9A]">Mantenimiento pendiente:</div>
                            <div class="w-2/3">
                                @if ($tool->needs_maintenance)
                                    <span class="px-5 py-2 bg-[#8A2BE2]/20 text-[#D4B8E8] rounded-full border border-[#8A2BE2]/40">Sí – Requiere atención</span>
                                @else
                                    <span class="px-5 py-2 bg-gray-800/50 text-gray-400 rounded-full border border-gray-600/50">No</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($tool->notes)
                        <div class="mt-10">
                            <h4 class="text-2xl font-bold text-[#C8A2C8] mb-4" style="text-shadow: 0 0 10px rgba(200,162,200,0.4);">
                                Notas / Observaciones
                            </h4>
                            <div class="bg-[#140d1a]/60 border-l-4 border-[#8A2BE2] p-6 rounded-xl text-[#D4B8E8]/90">
                                {{ $tool->notes }}
                            </div>
                        </div>
                    @endif

                    <div class="mt-10 pt-6 border-t border-[#C8A2C8]/20 text-sm text-[#D4B8E8]/80">
                        <p>Creado el: {{ $tool->created_at->format('d/m/Y H:i') }}</p>
                        <p>Última actualización: {{ $tool->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script para mostrar barcode grande en show -->
        @section('scripts')
            <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
            <script>
                @if ($tool->code)
                    JsBarcode("#barcode-large", "{{ $tool->code }}", {
                        format: "CODE128",
                        lineColor: "#8A2BE2",
                        width: 3,
                        height: 140,
                        fontSize: 28,
                        background: "#111",
                        margin: 20,
                        displayValue: true
                    });
                @endif
            </script>
        @endsection
    </div>
@endsection