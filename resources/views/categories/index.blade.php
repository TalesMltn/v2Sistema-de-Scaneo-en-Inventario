@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#eaeaea] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-6 flex-wrap">
                <h1 class="text-4xl md:text-5xl font-extrabold text-[#00f6ff] tracking-wide"
                    style="text-shadow: 0 0 15px #00f6ff, 0 0 35px rgba(0,246,255,0.6);">
                    CATEGORÍAS DEL INVENTARIO
                </h1>

                <div class="flex flex-wrap gap-5 justify-center sm:justify-end">
                    <a href="{{ route('dashboard') }}"
                       class="px-8 py-4 border-2 border-[#00f6ff] text-[#00f6ff] font-bold text-lg rounded-2xl 
                              hover:bg-[#00f6ff]/10 hover:shadow-[0_0_35px_rgba(0,246,255,0.7)] 
                              transition-all duration-300 flex items-center gap-2"
                       aria-label="Volver al panel principal">
                        <i class="fas fa-arrow-left"></i> VOLVER AL DASHBOARD
                    </a>

                    <a href="{{ route('categories.create') }}"
                       class="px-8 py-4 bg-[#ff8c00] text-black font-bold text-lg rounded-2xl 
                              shadow-[0_0_25px_rgba(255,140,0,0.7)] hover:bg-[#ff9f43] hover:shadow-[0_0_45px_rgba(255,140,0,1)]
                              transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-plus"></i> NUEVA CATEGORÍA
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-[#ff8c00]/20 border-l-4 border-[#ff8c00] text-[#ffb36b] p-5 rounded-xl mb-8 shadow-[0_0_15px_rgba(255,140,0,0.3)] animate-pulse">
                    {{ session('success') }}
                </div>
            @endif

            @if ($categories->isEmpty())
                <div class="bg-[#111]/70 border-2 border-[#00f6ff]/40 rounded-2xl p-12 text-center text-[#ff9f43]/80 text-xl font-medium">
                    Aún no hay categorías registradas.
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border-2 border-[#00f6ff]/30 shadow-[0_0_20px_rgba(0,246,255,0.25)]">
                    <table class="w-full text-left text-[#eaeaea] min-w-[800px]">
                        <thead class="bg-[#0a0a0a]/90 text-[#00f6ff] text-lg uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-5">Nombre</th>
                                <th class="px-6 py-5">Slug</th>
                                <th class="px-6 py-5 text-center">Imagen</th>
                                <th class="px-6 py-5 text-center">Activo</th>
                                <th class="px-6 py-5 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#00f6ff]/20">
                            @foreach ($categories as $category)
                                <tr class="bg-[#111]/60 hover:bg-[#1a1a1a]/80 transition-all duration-200">
                                    <td class="px-6 py-5 font-medium">{{ $category->name }}</td>
                                    <td class="px-6 py-5"><code class="text-[#a0f0ff] bg-[#000]/40 px-2 py-1 rounded">{{ $category->slug }}</code></td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($category->image)
                                            <img src="{{ Storage::url($category->image) }}" 
                                                 alt="{{ $category->name }}" 
                                                 class="inline-block rounded-lg border border-[#00f6ff]/30 shadow-[0_0_10px_rgba(0,246,255,0.3)]"
                                                 style="max-height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-[#ff9f43]/60 italic">Sin imagen</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($category->active)
                                            <span class="inline-block px-5 py-2 bg-green-600/40 text-green-300 rounded-full border border-green-400/30 font-medium">Sí</span>
                                        @else
                                            <span class="inline-block px-5 py-2 bg-gray-700/50 text-gray-300 rounded-full border border-gray-500/50 font-medium">No</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center gap-4">
                                            <!-- Ver detalles - Cian neón -->
                                            <a href="{{ route('categories.show', $category) }}" 
                                               class="p-4 bg-[#00f6ff]/10 text-[#00f6ff] rounded-xl hover:bg-[#00f6ff]/30 hover:shadow-[0_0_20px_rgba(0,246,255,0.7)] transition-all duration-300 transform hover:scale-110"
                                               title="Ver detalles" aria-label="Ver detalles de {{ $category->name }}">
                                                <i class="fas fa-eye text-xl"></i>
                                            </a>

                                            <!-- Editar - Amarillo/neón -->
                                            <a href="{{ route('categories.edit', $category) }}" 
                                               class="p-4 bg-yellow-500/10 text-yellow-400 rounded-xl hover:bg-yellow-500/30 hover:shadow-[0_0_20px_rgba(255,204,0,0.7)] transition-all duration-300 transform hover:scale-110"
                                               title="Editar" aria-label="Editar {{ $category->name }}">
                                                <i class="fas fa-edit text-xl"></i>
                                            </a>

                                            <!-- Eliminar - Rojo neón -->
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('¿Realmente deseas eliminar {{ $category->name }}?')"
                                                        class="p-4 bg-red-600/10 text-red-400 rounded-xl hover:bg-red-600/30 hover:shadow-[0_0_20px_rgba(255,68,68,0.7)] transition-all duration-300 transform hover:scale-110"
                                                        title="Eliminar" aria-label="Eliminar {{ $category->name }}">
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
@endsection