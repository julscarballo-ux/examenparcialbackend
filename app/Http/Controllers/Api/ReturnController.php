<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;

class ReturnController extends Controller
{
    /**
     * POST /api/returns/{loan_id}
     * Registra devolución, incrementa copias_disponibles. 422 si ya fue devuelto.
     */
    public function store(Loan $loan): JsonResponse
    {
        if ($loan->fecha_devolucion !== null) {
            return response()->json([
                'message' => 'Este préstamo ya fue devuelto.',
            ], 422);
        }

        $loan->update(['fecha_devolucion' => now()]);

        $book = $loan->book;
        $book->increment('copias_disponibles');

        if (!$book->disponible) {
            $book->update(['disponible' => true]);
        }

        return response()->json([
            'message' => 'Devolución registrada correctamente.',
        ], 200);
    }
}
