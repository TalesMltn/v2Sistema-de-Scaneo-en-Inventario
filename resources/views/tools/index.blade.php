@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#eaeaea] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-6 flex-wrap">
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#00f6ff] tracking-wide"
                    style="text-shadow: 0 0 15px #00f6ff, 0 0 35px rgba(0,246,255,0.6);">
                    HERRAMIENTAS / EQUIPOS
                </h1>

                <div class="flex flex-wrap gap-5 justify-center sm:justify-end">
                    <a href="{{ route('dashboard') }}"
                       class="px-8 py-4 border-2 border-[#00f6ff] text-[#00f6ff] font-bold text-lg rounded-2xl 
                              hover:bg-[#00f6ff]/10 hover:shadow-[0_0_35px_rgba(0,246,255,0.7)] 
                              transition-all duration-300 flex items-center gap-2"
                       aria-label="Volver al panel principal">
                        <i class="fas fa-arrow-left"></i> VOLVER AL DASHBOARD
                    </a>

                    <a href="{{ route('tools.create') }}"
                       class="px-8 py-4 bg-[#ff8c00] text-black font-bold text-lg rounded-2xl 
                              shadow-[0_0_25px_rgba(255,140,0,0.7)] hover:bg-[#ff9f43] hover:shadow-[0_0_45px_rgba(255,140,0,1)]
                              transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-plus"></i> NUEVA HERRAMIENTA
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-[#ff8c00]/20 border-l-4 border-[#ff8c00] text-[#ffb36b] p-5 rounded-xl mb-8 shadow-[0_0_15px_rgba(255,140,0,0.3)] animate-pulse">
                    {{ session('success') }}
                </div>
            @endif

            @if ($tools->isEmpty())
                <div class="bg-[#111]/70 border-2 border-[#00f6ff]/40 rounded-2xl p-12 text-center text-[#ff9f43]/80 text-xl font-medium">
                    No hay herramientas registradas todavía.
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border-2 border-[#00f6ff]/30 shadow-[0_0_20px_rgba(0,246,255,0.25)]">
                    <table class="w-full text-left text-[#eaeaea] min-w-[900px]">
                        <thead class="bg-[#0a0a0a]/90 text-[#00f6ff] text-lg uppercase tracking-wider">
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
                        <tbody class="divide-y divide-[#00f6ff]/20">
                            @foreach ($tools as $tool)
                                <tr class="bg-[#111]/60 hover:bg-[#1a1a1a]/80 transition-all duration-200">
                                    <td class="px-6 py-5 font-medium">{{ $tool->name }}</td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($tool->code)
                                            <div class="flex flex-col items-center gap-2">
                                                <svg id="barcode-{{ $tool->id }}" class="mx-auto w-40 h-20"></svg>
                                                <div class="flex items-center gap-3">
                                                    <span class="text-[#00f6ff] font-bold text-sm">{{ $tool->code }}</span>
                                                    
                                                    <!-- Botón de impresora (solo icono) -->
                                                    <button type="button" 
                                                            onclick="printToolBarcode('{{ $tool->id }}', '{{ addslashes($tool->name) }}', '{{ $tool->code }}')"
                                                            class="p-2 bg-[#111]/70 text-[#00f6ff] rounded-lg hover:bg-[#00f6ff]/20 hover:text-white transition-all"
                                                            title="Imprimir código de barras">
                                                        <i class="fas fa-print text-lg"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <script>
JsBarcode("#barcode-{{ $tool->id }}", "{{ $tool->code }}", {
    format: "CODE128",
    lineColor: "#000000",
    width: 2.6,
    height: 95,
    fontSize: 16,
    background: "#ffffff",
    margin: 8,
    displayValue: true
});
                                            </script>
                                        @else
                                            <span class="text-[#ff9f43]/70">Sin código</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">{{ $tool->category?->name ?? 'Sin categoría' }}</td>
                                    <td class="px-6 py-5 text-center text-xl font-bold">{{ $tool->stock }}</td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($tool->status === 'optimo')
                                            <span class="inline-block px-4 py-1 bg-green-600/40 text-green-300 rounded-full border border-green-400/30">Óptimo</span>
                                        @elseif ($tool->status === 'mantenimiento')
                                            <span class="inline-block px-4 py-1 bg-yellow-600/40 text-yellow-300 rounded-full border border-yellow-400/30">Mantenimiento</span>
                                        @else
                                            <span class="inline-block px-4 py-1 bg-red-600/40 text-red-300 rounded-full border border-red-400/30">Dañado</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($tool->needs_maintenance)
                                            <span class="inline-block px-4 py-1 bg-[#ff8c00]/30 text-[#ffb36b] rounded-full border border-[#ff8c00]/50">Necesita</span>
                                        @else
                                            <span class="inline-block px-4 py-1 bg-gray-700/50 text-gray-300 rounded-full border border-gray-500/50">No</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($tool->image)
                                            <img src="{{ Storage::url($tool->image) }}" 
                                                 alt="{{ $tool->name }}" 
                                                 class="inline-block rounded-lg border border-[#00f6ff]/30 shadow-[0_0_10px_rgba(0,246,255,0.3)]"
                                                 style="max-height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-[#ff9f43]/60 italic">Sin foto</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center gap-4">
                                            <a href="{{ route('tools.show', $tool) }}" 
                                               class="p-4 bg-[#00f6ff]/10 text-[#00f6ff] rounded-xl hover:bg-[#00f6ff]/30 hover:shadow-[0_0_20px_rgba(0,246,255,0.7)] transition-all duration-300 transform hover:scale-110"
                                               title="Ver detalles" aria-label="Ver detalles de {{ $tool->name }}">
                                                <i class="fas fa-eye text-xl"></i>
                                            </a>
                                            <a href="{{ route('tools.edit', $tool) }}" 
                                               class="p-4 bg-yellow-500/10 text-yellow-400 rounded-xl hover:bg-yellow-500/30 hover:shadow-[0_0_20px_rgba(255,204,0,0.7)] transition-all duration-300 transform hover:scale-110"
                                               title="Editar" aria-label="Editar {{ $tool->name }}">
                                                <i class="fas fa-edit text-xl"></i>
                                            </a>
                                            <form action="{{ route('tools.destroy', $tool) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('¿Seguro que deseas eliminar {{ $tool->name }}?')"
                                                        class="p-4 bg-red-600/10 text-red-400 rounded-xl hover:bg-red-600/30 hover:shadow-[0_0_20px_rgba(255,68,68,0.7)] transition-all duration-300 transform hover:scale-110"
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

                // Clonar el elemento barcode para imprimir solo él
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