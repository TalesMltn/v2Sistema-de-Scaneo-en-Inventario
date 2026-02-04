@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#eaeaea] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-6 flex-wrap">
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#00f6ff] tracking-wide"
                    style="text-shadow: 0 0 15px #00f6ff, 0 0 35px rgba(0,246,255,0.6);">
                    {{ $tool->name }}
                </h1>

                <div class="flex gap-4">
                    <a href="{{ route('tools.index') }}" 
                       class="px-8 py-4 border-2 border-[#00f6ff] text-[#00f6ff] font-bold rounded-2xl 
                              hover:bg-[#00f6ff]/10 hover:shadow-[0_0_35px_rgba(0,246,255,0.7)] transition-all">
                        Volver al listado
                    </a>
                    <a href="{{ route('tools.edit', $tool) }}" 
                       class="px-8 py-4 bg-[#ff8c00]/80 text-black font-bold rounded-2xl 
                              hover:bg-[#ff9f43] hover:shadow-[0_0_45px_rgba(255,140,0,0.8)] transition-all flex items-center gap-2">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Imagen -->
                <div class="md:col-span-2">
                    @if ($tool->image)
                        <div class="relative rounded-3xl overflow-hidden border-2 border-[#00f6ff]/50 
                                    shadow-[0_0_30px_rgba(0,246,255,0.5)]">
                            <img src="{{ Storage::url($tool->image) }}" 
                                 alt="{{ $tool->name }}" 
                                 class="w-full h-auto object-contain">
                        </div>
                    @else
                        <div class="bg-[#111]/70 border-2 border-[#00f6ff]/30 rounded-3xl h-80 flex items-center justify-center">
                            <span class="text-[#ff9f43]/70 text-2xl">Sin imagen</span>
                        </div>
                    @endif
                </div>

                <!-- Detalles -->
                <div class="md:col-span-3 bg-[#0a0a0a]/70 backdrop-blur-sm border-2 border-[#00f6ff]/40 
                            rounded-3xl p-8 shadow-[0_0_25px_rgba(0,246,255,0.3)]">
                    <h3 class="text-3xl font-bold text-[#00f6ff] mb-8" style="text-shadow: 0 0 12px #00f6ff;">
                        Detalles
                    </h3>

                    <div class="space-y-6 text-lg">
                        <div class="flex flex-col items-center md:items-start">
                            <div class="w-full md:w-auto font-bold text-[#ff9f43] mb-2">Código:</div>
                            <div class="text-3xl font-bold text-[#00f6ff] mb-4">{{ $tool->code ?? 'No asignado' }}</div>
                            <!-- Código de barras grande -->
                            @if ($tool->code)
                                <div id="barcode-show" class="bg-white p-6 rounded-2xl shadow-[0_0_30px_rgba(0,246,255,0.5)]">
                                    <svg id="barcode-large"></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-bold text-[#ff9f43]">Categoría:</div>
                            <div class="w-2/3">{{ $tool->category?->name ?? 'Sin categoría' }}</div>
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-bold text-[#ff9f43]">Stock actual:</div>
                            <div class="w-2/3 flex items-center gap-3">
                                <span class="text-2xl font-bold">{{ $tool->stock }}</span>
                                @if ($tool->stock <= 0)
                                    <span class="px-4 py-1 bg-red-600/50 text-red-200 rounded-full border border-red-400/40">Sin stock</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-bold text-[#ff9f43]">Estado:</div>
                            <div class="w-2/3">
                                @if ($tool->status === 'optimo')
                                    <span class="px-5 py-2 bg-green-600/40 text-green-300 rounded-full border border-green-400/30">Óptimo</span>
                                @elseif ($tool->status === 'mantenimiento')
                                    <span class="px-5 py-2 bg-yellow-600/40 text-yellow-300 rounded-full border border-yellow-400/30">En mantenimiento</span>
                                @else
                                    <span class="px-5 py-2 bg-red-600/40 text-red-300 rounded-full border border-red-400/30">Dañado</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-1/3 font-bold text-[#ff9f43]">Mantenimiento pendiente:</div>
                            <div class="w-2/3">
                                @if ($tool->needs_maintenance)
                                    <span class="px-5 py-2 bg-[#ff8c00]/40 text-[#ffb36b] rounded-full border border-[#ff8c00]/50">Sí – Requiere atención</span>
                                @else
                                    <span class="px-5 py-2 bg-gray-700/50 text-gray-300 rounded-full border border-gray-500/50">No</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($tool->notes)
                        <div class="mt-10">
                            <h4 class="text-2xl font-bold text-[#00f6ff] mb-4" style="text-shadow: 0 0 10px #00f6ff;">
                                Notas / Observaciones
                            </h4>
                            <div class="bg-[#111]/60 border-l-4 border-[#ff8c00] p-6 rounded-xl text-[#ffb36b]/90">
                                {{ $tool->notes }}
                            </div>
                        </div>
                    @endif

                    <div class="mt-10 pt-6 border-t border-[#00f6ff]/20 text-sm text-[#a0a0a0]">
                        <p>Creado el: {{ $tool->created_at->format('d/m/Y H:i') }}</p>
                        <p>Última actualización: {{ $tool->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script para mostrar barcode grande en show -->
        @section('scripts')
            <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
            <script>
                @if ($tool->code)
                    JsBarcode("#barcode-large", "{{ $tool->code }}", {
                        format: "CODE128",
                        lineColor: "#00f6ff",
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