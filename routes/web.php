<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ToolController;

// Rutas PÚBLICAS (sin login) → ESCANEO DIRECTO + herramientas disponibles
Route::post('/scan/process', [ScanController::class, 'process'])->name('scan.process');
Route::get('/scan/last-movements', [ScanController::class, 'lastMovements']);

// Ruta pública para herramientas disponibles (para que carguen sin login)
Route::get('/tools/available', function () {
    $tools = \App\Models\Tool::with('category')
        ->where('stock', '>', 0)
        ->latest()
        ->take(12)  // Puedes quitar take() si quieres mostrar TODAS
        ->get();

    return response()->json($tools->map(function ($tool) {
        return [
            'id' => $tool->id,
            'name' => $tool->name,
            'code' => $tool->code ?? 'Sin código',
            'category' => $tool->category?->name ?? 'Sin categoría',
            'stock' => $tool->stock,
            'status' => $tool->status,
            'image' => $tool->image ? Storage::url($tool->image) : null,
        ];
    }));
})->name('tools.available');

// Página principal (welcome si no está logueado, dashboard si sí)
Route::get('/', function () {
    return Auth::check() 
        ? redirect()->route('dashboard') 
        : view('welcome');
})->name('welcome');

// Rutas de autenticación (solo para usuarios no autenticados)
Route::middleware('guest')->group(function () {

    // Mostrar formulario de login
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // Procesar login
    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'El correo o contraseña no coinciden.',
        ])->onlyInput('email');
    })->name('login.attempt');

});

// Logout (solo para usuarios autenticados)
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome');
})->name('logout')->middleware('auth');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {

    // Dashboard principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Recursos completos para categorías
    Route::resource('categories', CategoryController::class)
        ->names('categories');

    // Recursos completos para herramientas
    Route::resource('tools', ToolController::class)
        ->names('tools');

    // Ruta para generar código único de herramienta (usada en el botón "Generar" del create)
    Route::get('/tools/generate-code', function () {
        $lastTool = \App\Models\Tool::latest('id')->first();
        $nextNumber = $lastTool ? (int) substr($lastTool->code ?? 'HR00000', 2) + 1 : 1;
        $code = 'HR' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Verificar unicidad (por si acaso alguien crea al mismo tiempo)
        while (\App\Models\Tool::where('code', $code)->exists()) {
            $nextNumber++;
            $code = 'HR' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        }

        return response()->json(['code' => $code]);
    })->name('tools.generate-code');

});