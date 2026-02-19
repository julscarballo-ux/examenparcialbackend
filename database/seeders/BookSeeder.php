<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BookSeeder extends Seeder
{
    /**
     * Seed the application's database with 10 clásicos (CSV) + 90 generados (Factory).
     * Total: 100 libros.
     */
    public function run(): void
    {
        $csvPath = database_path('data/books_classics.csv');

        if (!File::exists($csvPath)) {
            $this->command->error('No se encontró database/data/books_classics.csv');
            return;
        }

        $rows = array_map('str_getcsv', file($csvPath));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (count($row) < count($header)) {
                continue;
            }
            $data = array_combine($header, $row);
            Book::create([
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'],
                'isbn' => $data['isbn'],
                'copias_totales' => (int) $data['copias_totales'],
                'copias_disponibles' => (int) $data['copias_disponibles'],
                'disponible' => (bool) (int) ($data['disponible'] ?? 1),
            ]);
        }

        Book::factory(90)->create();
    }
}

