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
            // Obtener el código del request (puede venir como 'code' o 'data')
            $code = $request->input('code') ?? $request->input('data');

            if (!$code) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se recibió código'
                ], 400);
            }

            Log::info('Escaneo recibido:', ['code' => $code]);

            // Buscar la herramienta
            $tool = Tool::where('code', $code)->first();

            if (!$tool) {
                return response()->json([
                    'success' => false,
                    'message' => 'Herramienta no encontrada'
                ], 404);
            }

            $stockBefore = $tool->stock;

            if ($tool->is_out) {
                // Devolución (entrada)
                $tool->is_out = false;
                $tool->stock += 1;
                $action = 'devolucion';
            } else {
                // Salida
                if ($tool->stock <= 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sin stock disponible'
                    ], 422);
                }
                $tool->is_out = true;
                $tool->stock -= 1;
                $action = 'salida';
            }

            $tool->save();

            // Registrar el movimiento
            Movement::create([
                'tool_id'      => $tool->id,
                'type'         => $action,
                'stock_before' => $stockBefore,
                'stock_after'  => $tool->stock,
            ]);

            return response()->json([
                'success'    => true,
                'action'     => $action,
                'tool_name'  => $tool->name,
                'code'       => $tool->code,
                'new_stock'  => $tool->stock,
            ]);

        } catch (\Exception $e) {
            // Loggear el error para debug
            Log::error('Error en scan/process:', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'code'    => $code ?? 'no recibido'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function lastMovements()
    {
        $movements = Movement::with('tool')
            ->latest()
            ->take(10)
            ->get();

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