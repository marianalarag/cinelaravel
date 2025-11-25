<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            'Acción', 'Aventura', 'Comedia', 'Drama', 'Terror',
            'Ciencia Ficción', 'Fantasía', 'Romance', 'Suspenso',
            'Animación', 'Documental', 'Musical'
        ];

        foreach ($genres as $genre) {
            Genre::updateOrCreate(
                ['name' => $genre],
                ['is_active' => true]
            );
        }
    }
}
