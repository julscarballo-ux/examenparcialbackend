<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     * copias_disponibles nunca excede copias_totales.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $copiasTotales = fake()->numberBetween(1, 10);
        $copiasDisponibles = fake()->numberBetween(0, $copiasTotales);
        $disponible = $copiasDisponibles > 0;

        return [
            'titulo' => fake()->sentence(3),
            'descripcion' => fake()->paragraph(),
            'isbn' => (string) fake()->unique()->numerify('#############'),
            'copias_totales' => $copiasTotales,
            'copias_disponibles' => $copiasDisponibles,
            'disponible' => $disponible,
        ];
    }
}