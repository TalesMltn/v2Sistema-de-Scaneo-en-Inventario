<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::with('category')->orderBy('name')->get();

        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'stock'       => 'required|integer|min:0',
        'status'      => 'required|in:optimo,mantenimiento,dañado',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        // otros campos...
    ]);

    // Generar código único automáticamente (ej: HR + 5 dígitos)
    $lastTool = Tool::latest('id')->first();
    $nextNumber = $lastTool ? (int) substr($lastTool->code ?? 'HR00000', 2) + 1 : 1;
    $code = 'HR' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);  // HR00001, HR00002...

    // Verificar unicidad (por si acaso)
    while (Tool::where('code', $code)->exists()) {
        $nextNumber++;
        $code = 'HR' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    $data = $validated;
    $data['code'] = $code;
    $data['slug'] = Str::slug($validated['name']);  // si usas slug

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('tools', 'public');
    }

    Tool::create($data);

    return redirect()->route('tools.index')
                     ->with('success', 'Herramienta creada exitosamente con código: ' . $code);
}

    public function show(Tool $tool)
    {
        $tool->load('category');
        return view('tools.show', compact('tool'));
    }

    public function edit(Tool $tool)
    {
        $categories = Category::get();
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'code'              => 'nullable|string|max:100|unique:tools,code,' . $tool->id,
            'category_id'       => 'required|exists:categories,id',
            'stock'             => 'required|integer|min:0',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'            => 'required|in:optimo,mantenimiento,dañado',
            'needs_maintenance' => 'boolean',
            'notes'             => 'nullable|string',
        ]);

        $data = $request->only([
            'name', 'code', 'category_id', 'stock', 'status', 'notes'
        ]);
        $data['needs_maintenance'] = $request->has('needs_maintenance');

        if ($request->hasFile('image')) {
            if ($tool->image) {
                Storage::disk('public')->delete($tool->image);
            }
            $data['image'] = $request->file('image')->store('tools', 'public');
        }

        $tool->update($data);

        return redirect()->route('tools.index')->with('success', 'Herramienta actualizada exitosamente.');
    }

    public function destroy(Tool $tool)
    {
        if ($tool->image) {
            Storage::disk('public')->delete($tool->image);
        }

        $tool->delete();

        return redirect()->route('tools.index')->with('success', 'Herramienta eliminada exitosamente.');
    }
}