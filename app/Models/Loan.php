<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'nombre_solicitante',
        'book_id',
        'fecha_prestamo',
        'fecha_devolucion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_prestamo' => 'datetime',
            'fecha_devolucion' => 'datetime',
        ];
    }

    /**
     * Libro asociado a este préstamo (relación Eloquent).
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Indica si el préstamo está activo (libro no devuelto).
     */
    public function isActivo(): bool
    {
        return $this->fecha_devolucion === null;
    }
}