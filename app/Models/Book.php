<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'isbn',
        'copias_totales',
        'copias_disponibles',
        'disponible',
    ];

    protected function casts(): array
    {
        return [
            'disponible' => 'boolean',
        ];
    }

    /**
     * Préstamos asociados a este libro (relación Eloquent).
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}