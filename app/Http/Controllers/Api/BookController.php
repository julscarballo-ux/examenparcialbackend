<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * GET /api/books
     * Filtros: titulo, isbn, status (disponible = true/false o 1/0).
     */
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('titulo')) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        if ($request->filled('isbn')) {
            $query->where('isbn', $request->isbn);
        }

        if ($request->has('status')) {
            $status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $query->where('disponible', $status);
        }

        $books = $query->get();

        return BookResource::collection($books);
    }
}