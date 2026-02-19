<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'isbn' => $this->isbn,
            'copias_totales' => $this->copias_totales,
            'copias_disponibles' => $this->copias_disponibles,
            'estado' => $this->disponible,
        ];
    }
}
