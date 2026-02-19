<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequest;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    /**
     * POST /api/loans
     * Crea préstamo, reduce copias_disponibles. 422 si no hay existencias.
     */
    public function store(StoreLoanRequest $request): JsonResponse
    {
        $book = Book::findOrFail($request->validated('book_id'));

        if ($book->copias_disponibles <= 0) {
            return response()->json([
                'message' => 'No hay copias disponibles para este libro.',
            ], 422);
        }

        $loan = Loan::create([
            'nombre_solicitante' => $request->validated('nombre_solicitante'),
            'book_id' => $book->id,
            'fecha_prestamo' => $request->validated('fecha_prestamo'),
        ]);

        $book->decrement('copias_disponibles');

        if ($book->copias_disponibles === 0) {
            $book->update(['disponible' => false]);
        }

        return response()->json([
            'message' => 'Préstamo registrado correctamente.',
            'loan_id' => $loan->id,
        ], 201);
    }

    /**
     * GET /api/loans/history
     * Historial de préstamos con libro (relación Eloquent). Estado: "Activo" o "Devuelto".
     */
    public function history()
    {
        $loans = Loan::with('book')->orderByDesc('fecha_prestamo')->get();

        return response()->json([
            'data' => $loans->map(function (Loan $loan) {
                return [
                    'id' => $loan->id,
                    'nombre_solicitante' => $loan->nombre_solicitante,
                    'fecha_prestamo' => $loan->fecha_prestamo->toIso8601String(),
                    'fecha_devolucion' => $loan->fecha_devolucion?->toIso8601String(),
                    'estado_prestamo' => $loan->isActivo() ? 'Activo' : 'Devuelto',
                    'libro' => [
                        'id' => $loan->book->id,
                        'titulo' => $loan->book->titulo,
                        'isbn' => $loan->book->isbn,
                    ],
                ];
            }),
        ]);
    }
}