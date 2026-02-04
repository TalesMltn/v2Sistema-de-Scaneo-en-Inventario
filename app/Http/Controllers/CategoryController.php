<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'nullable|in:on,off,1,0,true,false',  // ← CAMBIA ESTA LÍNEA
        ]);
    
        // 2. Preparar datos (el slug se genera automáticamente en el mutator del modelo)
        $data = [
            'name'   => $validated['name'],
            'active' => $request->boolean('active', false),   // esto convierte "on" → true, nada → false
        ];
    
        // 3. Guardar imagen si existe
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
    
        // 4. Crear la categoría (aquí se ejecuta el mutator setNameAttribute)
        $category = Category::create($data);
    
        // 5. Redirigir con mensaje de éxito
        return redirect()->route('categories.index')
                         ->with('success', '¡Categoría creada exitosamente!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        $data = $request->only(['name', 'active']);
        $data['active'] = $request->has('active');

        // Manejo de nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Eliminar la imagen si existe
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}