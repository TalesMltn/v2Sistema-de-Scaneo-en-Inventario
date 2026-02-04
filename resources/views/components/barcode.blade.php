<div class="text-center bg-white p-6 rounded-2xl shadow-lg border border-gray-300 inline-block">
    @if ($code ?? false)
        <svg id="barcode-{{ $id ?? 'default' }}" aria-label="Código de barras: {{ $code }}"></svg>
        <p class="mt-3 text-lg font-medium text-black">{{ $code }}</p>
    @else
        <p class="text-red-600 font-medium">Código no proporcionado</p>
    @endif
</div>