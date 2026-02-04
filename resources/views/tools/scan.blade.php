<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    public function process(Request $request)
    {
        try {
            // Obtener código (soporta 'code' o 'data')
            $code = $request->input('code') ?? $request->input('data');

            if (!$code) {
                Log::warning('Escaneo sin código recibido');
                return response()->json(['success' => false, 'message' => 'No se recibió código'], 400);
            }

            Log::info('Escaneo recibido:', ['code' => $code]);

            $tool = Tool::where('code', $code)->first();

            if (!$tool) {
                Log::info('Herramienta no encontrada:', ['code' => $code]);
                return response()->json(['success' => false, 'message' => 'Código no encontrado'], 404);
            }

            // Verificar campos obligatorios
            if (!isset($tool->stock) || !is_numeric($tool->stock)) {
                Log::error('Stock inválido para herramienta:', ['id' => $tool->id, 'stock' => $tool->stock]);
                return response()->json(['success' => false, 'message' => 'Error: stock inválido en la base de datos'], 500);
            }

            $stockBefore = (int) $tool->stock;

            if ($tool->is_out ?? false) {  // Usa ?? para evitar error si is_out es null
                // Devolución
                $tool->is_out = false;
                $tool->stock = $stockBefore + 1;
                $action = 'devolucion';
            } else {
                // Salida
                if ($stockBefore <= 0) {
                    return response()->json(['success' => false, 'message' => 'Sin stock disponible'], 422);
                }
                $tool->is_out = true;
                $tool->stock = $stockBefore - 1;
                $action = 'salida';
            }

            $tool->save();

            // Registrar movimiento
            Movement::create([
                'tool_id'      => $tool->id,
                'type'         => $action,
                'stock_before' => $stockBefore,
                'stock_after'  => $tool->stock,
            ]);

            Log::info('Movimiento registrado:', [
                'tool_id' => $tool->id,
                'action'  => $action,
                'stock'   => $tool->stock
            ]);

            return response()->json([
                'success'    => true,
                'action'     => $action,
                'tool_name'  => $tool->name,
                'code'       => $tool->code,
                'new_stock'  => $tool->stock,
            ]);

        } catch (\Exception $e) {
            Log::error('Error crítico en scan/process:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
                'code'    => $code ?? 'desconocido'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }

    public function lastMovements()
    {
        $movements = Movement::with('tool')->latest()->take(10)->get();

        return response()->json($movements->map(function ($m) {
            return [
                'tool_name' => $m->tool->name ?? 'Desconocida',
                'code'      => $m->tool->code ?? 'N/A',
                'action'    => $m->type,
                'time_ago'  => $m->created_at->diffForHumans(),
            ];
        }));
    }
}