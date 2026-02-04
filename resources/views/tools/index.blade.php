@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#f0e6ff] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-6 flex-wrap">
                <h1 class="text-4xl md:text-5xl font-extrabold text-center text-[#C8A2C8] tracking-wide"
                    style="text-shadow: 0 0 18px #C8A2C8, 0 0 40px rgba(200,162,200,0.55);">
                    HERRAMIENTAS / EQUIPOS
                </h1>

                <div class="flex flex-wrap gap-5 justify-center sm:justify-end">
                    <a href="{{ route('dashboard') }}"
                       class="px-8 py-4 border-2 border-[#C8A2C8] text-[#C8A2C8] font-bold text-lg rounded-2xl 
                              hover:bg-[#C8A2C8]/15 hover:shadow-[0_0_35px_rgba(200,162,200,0.6)] 
                              transition-all duration-300 flex items-center gap-2"
                       aria-label="Volver al panel principal">
                        <i class="fas fa-arrow-left"></i> VOLVER AL DASHBOARD
                    </a>

                    <a href="{{ route('tools.create') }}"
                       class="px-8 py-4 bg-[#8A2BE2] text-white font-bold text-lg rounded-2xl 
                              shadow-[0_0_30px_rgba(138,43,226,0.6)] hover:bg-[#9f5cf5] hover:shadow-[0_0_50px_rgba(138,43,226,0.9)]
                              transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-plus"></i> NUEVA HERRAMIENTA
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-[#8A2BE2]/10 border-l-4 border-[#8A2BE2] text-[#E3BC9A] p-5 rounded-xl mb-8 shadow-[0_0_15px_rgba(138,43,226,0.25)]">
                    {{ session('success') }}
                </div>
            @endif

            @if ($tools->isEmpty())
                <div class="bg-[#140d1a]/70 border-2 border-[#C8A2C8]/40 rounded-2xl p-12 text-center text-[#E3BC9A]/80 text-xl font-medium">
                    No hay herramientas registradas todavía.
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border-2 border-[#C8A2C8]/30 shadow-[0_0_25px_rgba(200,162,200,0.25)]">
                    <table class="w-full text-left text-[#f0e6ff] min-w-[900px]">
                        <thead class="bg-[#0f0b14]/90 text-[#C8A2C8] text-lg uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="px-6 py-5">Nombre</th>
                                <th class="px-6 py-5">Código</th>
                                <th class="px-6 py-5">Categoría</th>
                                <th class="px-6 py-5 text-center">Stock</th>
                                <th class="px-6 py-5 text-center">Estado</th>
                                <th class="px-6 py-5 text-center">Mantenimiento</th>
                                <th class="px-6 py-5 text-center">Imagen</th>
                                <th class="px-6 py-5 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#C8A2C8]/20">
                            @foreach ($tools as $tool)
                                <tr class="bg-[#140d1a]/60 hover:bg-[#1a0d2e]/80 transition-all duration-300">
                                    <td class="px-6 py-5 font-medium text-[#f0e6ff]">{{ $tool->name }}</td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($tool->code)
                                            <div class="flex flex-col items-center gap-2">
                                                <svg id="barcode-{{ $tool->id }}" class="mx-auto w-40 h-20"></svg>
                                                <div class="flex items-center gap-3">
                                                    <span class="text-[#D4B8E8] font-bold text-sm">{{ $tool->code }}</span>
                                                    
                                                    <!-- Botón de impresora -->
                                                    <button type="button" 
                                                            onclick="printToolBarcode('{{ $tool->id }}', '{{ addslashes($tool->name) }}', '{{ $tool->code }}')"
                                                            class="p-2 bg-[#140d1a]/70 text-[#C8A2C8] rounded-lg hover:bg-[#C8A2C8]/20 hover:text-white transition-all"
                                                            title="Imprimir código de barras">
                                                        <i class="fas fa-print text-lg"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <script>
                                                JsBarcode("#barcode-{{ $tool->id }}", "{{ $tool->code }}", {
                                                    format: "CODE128",
                                                    lineColor: "#000000",
                                                    width: 2.2,
                                                    height: 80,
                                                    fontSize: 14,
                                                    background: "#ffffff",
                                                    margin: 5,
                                                    displayValue: true
                                                });
                                            </script>
                                        @else
                                            <span class="text-[#E3BC9A]/70">Sin código</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">{{ $tool->category?->name ?? 'Sin categoría' }}</td>
                                    <td class="px-6 py-5 text-center text-xl font-bold">{{ $tool->stock }}</td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($tool->status === 'optimo')
                                            <span class="inline-block px-4 py-1 bg-green-700/30 text-green-300 rounded-full border border-green-500/40">Óptimo</span>
                                        @elseif ($tool->status === 'mantenimiento')
                                            <span class="inline-block px-4 py-1 bg-yellow-700/30 text-yellow-300 rounded-full border border-yellow-500/40">Mantenimiento</span>
                                        @else
                                            <span class="inline-block px-4 py-1 bg-red-900/40 text-red-300 rounded-full border border-red-600/40">Dañado</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($tool->needs_maintenance)
                                            <span class="inline-block px-4 py-1 bg-[#8A2BE2]/20 text-[#D4B8E8] rounded-full border border-[#8A2BE2]/40">Necesita</span>
                                        @else
                                            <span class="inline-block px-4 py-1 bg-gray-800/50 text-gray-400 rounded-full border border-gray-600/50">No</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($tool->image)
                                            <img src="{{ Storage::url($tool->image) }}" 
                                                 alt="{{ $tool->name }}" 
                                                 class="inline-block rounded-lg border border-[#C8A2C8]/40 shadow-[0_0_12px_rgba(200,162,200,0.25)]"
                                                 style="max-height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-[#E3BC9A]/60 italic">Sin foto</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center gap-5">
                                            <a href="{{ route('tools.show', $tool) }}" 
                                               class="p-4 bg-[#C8A2C8]/10 text-[#C8A2C8] rounded-xl 
                                                      hover:bg-[#C8A2C8]/25 hover:shadow-[0_0_25px_rgba(200,162,200,0.5)] 
                                                      transition-all duration-300 transform hover:scale-110"
                                               title="Ver detalles" aria-label="Ver detalles de {{ $tool->name }}">
                                                <i class="fas fa-eye text-xl"></i>
                                            </a>
                                            <a href="{{ route('tools.edit', $tool) }}" 
                                               class="p-4 bg-[#8A2BE2]/10 text-[#8A2BE2] rounded-xl 
                                                      hover:bg-[#8A2BE2]/30 hover:shadow-[0_0_25px_rgba(138,43,226,0.6)] 
                                                      transition-all duration-300 transform hover:scale-110"
                                               title="Editar" aria-label="Editar {{ $tool->name }}">
                                                <i class="fas fa-edit text-xl"></i>
                                            </a>
                                            <form action="{{ route('tools.destroy', $tool) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('¿Seguro que deseas eliminar {{ $tool->name }}?')"
                                                        class="p-4 bg-red-900/20 text-red-400 rounded-xl 
                                                               hover:bg-red-900/40 hover:shadow-[0_0_25px_rgba(239,68,68,0.4)] 
                                                               transition-all duration-300 transform hover:scale-110"
                                                        title="Eliminar" aria-label="Eliminar {{ $tool->name }}">
                                                    <i class="fas fa-trash text-xl"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
        <script>
            // Función para imprimir SOLO el barcode de una herramienta
            function printToolBarcode(toolId, name, code) {
                const barcodeElement = document.getElementById('barcode-' + toolId);

                if (!barcodeElement) return;

                const printContent = barcodeElement.outerHTML;

                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Imprimir: ${name} - ${code}</title>
                        <style>
                            @page { size: auto; margin: 10mm; }
                            body { margin: 0; padding: 20px; font-family: Arial, sans-serif; text-align: center; background: white; }
                            svg { width: 100%; max-width: 400px; height: auto; margin: 20px 0; }
                            h2 { font-size: 24px; color: #333; margin-bottom: 20px; }
                            .no-print { display: none; }
                        </style>
                    </head>
                    <body onload="window.print(); setTimeout(() => window.close(), 2000);">
                        <h2>${name} - ${code}</h2>
                        ${printContent}
                    </body>
                    </html>
                `);
                printWindow.document.close();
            }

            // Generar todos los barcodes al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[id^="barcode-"]').forEach(el => {
                    const code = el.id.replace('barcode-', '');
                    JsBarcode("#" + el.id, code, {
                        format: "CODE128",
                        lineColor: "#000000",
                        width: 2.2,
                        height: 80,
                        fontSize: 14,
                        background: "#ffffff",
                        margin: 5,
                        displayValue: true
                    });
                });
            });
        </script>
    @endsection
@endsection