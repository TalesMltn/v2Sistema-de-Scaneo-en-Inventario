@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#0a0a0a] to-black text-[#f0e6ff] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-6 flex-wrap">
                <h1 class="text-4xl md:text-5xl font-extrabold text-center text-[#C8A2C8] tracking-wide"
                    style="text-shadow: 0 0 18px #C8A2C8, 0 0 40px rgba(200,162,200,0.55);">
                    CATEGORÍAS DEL INVENTARIO
                </h1>

                <div class="flex flex-wrap gap-5 justify-center sm:justify-end">
                    <a href="{{ route('dashboard') }}"
                       class="px-8 py-4 border-2 border-[#C8A2C8] text-[#C8A2C8] font-bold text-lg rounded-2xl 
                              hover:bg-[#C8A2C8]/15 hover:shadow-[0_0_35px_rgba(200,162,200,0.6)] 
                              transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> VOLVER AL DASHBOARD
                    </a>

                    <a href="{{ route('categories.create') }}"
                       class="px-8 py-4 bg-[#8A2BE2] text-white font-bold text-lg rounded-2xl 
                              shadow-[0_0_30px_rgba(138,43,226,0.6)] hover:bg-[#9f5cf5] hover:shadow-[0_0_50px_rgba(138,43,226,0.9)]
                              transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-plus"></i> NUEVA CATEGORÍA
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-[#8A2BE2]/10 border-l-4 border-[#8A2BE2] text-[#E3BC9A] p-5 rounded-xl mb-8 shadow-[0_0_15px_rgba(138,43,226,0.25)]">
                    {{ session('success') }}
                </div>
            @endif

            @if ($categories->isEmpty())
                <div class="bg-[#140d1a]/70 border-2 border-[#C8A2C8]/40 rounded-2xl p-12 text-center text-[#E3BC9A]/80 text-xl font-medium">
                    Aún no hay categorías registradas.
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border-2 border-[#C8A2C8]/30 shadow-[0_0_25px_rgba(200,162,200,0.25)]">
                    <table class="w-full text-left text-[#f0e6ff] min-w-[800px]">
                        <thead class="bg-[#0f0b14]/90 text-[#C8A2C8] text-lg uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="px-6 py-5">Nombre</th>
                                <th class="px-6 py-5">Slug</th>
                                <th class="px-6 py-5 text-center">Imagen</th>
                                <th class="px-6 py-5 text-center">Activo</th>
                                <th class="px-6 py-5 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#C8A2C8]/20">
                            @foreach ($categories as $category)
                                <tr class="bg-[#140d1a]/60 hover:bg-[#1a0d2e]/80 transition-all duration-300">
                                    <td class="px-6 py-5 font-medium text-[#f0e6ff]">{{ $category->name }}</td>
                                    <td class="px-6 py-5">
                                        <code class="text-[#D4B8E8] bg-[#0f0b14]/60 px-2 py-1 rounded font-mono">
                                            {{ $category->slug }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($category->image)
                                            <img src="{{ Storage::url($category->image) }}" 
                                                 alt="{{ $category->name }}" 
                                                 class="inline-block rounded-lg border border-[#C8A2C8]/40 shadow-[0_0_12px_rgba(200,162,200,0.25)]"
                                                 style="max-height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-[#E3BC9A]/70 italic">Sin imagen</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($category->active)
                                            <span class="inline-block px-5 py-2 bg-[#8A2BE2]/20 text-[#D4B8E8] rounded-full border border-[#8A2BE2]/40 font-medium">
                                                Sí
                                            </span>
                                        @else
                                            <span class="inline-block px-5 py-2 bg-gray-800/50 text-gray-400 rounded-full border border-gray-600/50 font-medium">
                                                No
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center gap-5">
                                            <!-- Ver detalles -->
                                            <a href="{{ route('categories.show', $category) }}" 
                                               class="p-4 bg-[#C8A2C8]/10 text-[#C8A2C8] rounded-xl 
                                                      hover:bg-[#C8A2C8]/25 hover:shadow-[0_0_25px_rgba(200,162,200,0.5)] 
                                                      transition-all duration-300 transform hover:scale-110"
                                               title="Ver detalles" aria-label="Ver detalles de {{ $category->name }}">
                                                <i class="fas fa-eye text-xl"></i>
                                            </a>

                                            <!-- Editar -->
                                            <a href="{{ route('categories.edit', $category) }}" 
                                               class="p-4 bg-[#8A2BE2]/10 text-[#8A2BE2] rounded-xl 
                                                      hover:bg-[#8A2BE2]/30 hover:shadow-[0_0_25px_rgba(138,43,226,0.6)] 
                                                      transition-all duration-300 transform hover:scale-110"
                                               title="Editar" aria-label="Editar {{ $category->name }}">
                                                <i class="fas fa-edit text-xl"></i>
                                            </a>

                                            <!-- Eliminar -->
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('¿Realmente deseas eliminar {{ $category->name }}?')"
                                                        class="p-4 bg-red-900/20 text-red-400 rounded-xl 
                                                               hover:bg-red-900/40 hover:shadow-[0_0_25px_rgba(239,68,68,0.4)] 
                                                               transition-all duration-300 transform hover:scale-110"
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