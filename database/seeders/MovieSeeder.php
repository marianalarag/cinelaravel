<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run()
    {
        $movies = [
            [
                'title' => 'Avengers: Endgame',
                'description' => 'Los Vengadores restantes deben encontrar una manera de recuperar a sus aliados para un enfrentamiento épico con Thanos.',
                'duration' => 181,
                'release_date' => '2024-04-26',
                'director' => 'Anthony Russo, Joe Russo',
                'cast' => 'Robert Downey Jr., Chris Evans, Mark Ruffalo',
                'genre' => 'Acción',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg',
                'trailer_url' => 'https://youtube.com/embed/TcMBFSGVi1c',
                'is_active' => true
            ],
            [
                'title' => 'The Batman',
                'description' => 'Batman se enfrenta al acertijo mientras recorre la corrupción de Gotham City.',
                'duration' => 176,
                'release_date' => '2024-03-04',
                'director' => 'Matt Reeves',
                'cast' => 'Robert Pattinson, Zoë Kravitz, Paul Dano',
                'genre' => 'Suspenso',
                'poster_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIMCpS3OjmxGAhuR99vetHATrUSMK2Cih6TB10Dnk9op5yB-y4DEVQsw9h3814Z8MirrCe&s=10',
                'trailer_url' => 'https://youtube.com/embed/mqqft2x_Aa4',
                'is_active' => true
            ],
            [
                'title' => 'Spider-Man: No Way Home',
                'description' => 'Peter Parker desata el multiverso con un hechizo que sale mal.',
                'duration' => 148,
                'release_date' => '2024-12-17',
                'director' => 'Jon Watts',
                'cast' => 'Tom Holland, Zendaya, Benedict Cumberbatch',
                'genre' => 'Ciencia Ficción',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg',
                'trailer_url' => 'https://youtube.com/embed/JfVOs4VSpmA',
                'is_active' => true
            ],
            [
                'title' => 'Dune: Part Two',
                'description' => 'Paul Atreides se une a los Fremen para vengar a su familia y liberar Arrakis.',
                'duration' => 166,
                'release_date' => '2024-03-01',
                'director' => 'Denis Villeneuve',
                'cast' => 'Timothée Chalamet, Zendaya, Rebecca Ferguson',
                'genre' => 'Ciencia Ficción',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/8b8R8l88Qje9dn9OE8PY05Nxl1X.jpg',
                'trailer_url' => 'https://youtube.com/embed/U2Qp5pL3ovA',
                'is_active' => true
            ],
            [
                'title' => 'John Wick 4',
                'description' => 'John Wick descubre un camino para derrotar a la Alta Mesa, pero debe enfrentarse a un nuevo enemigo.',
                'duration' => 169,
                'release_date' => '2024-03-24',
                'director' => 'Chad Stahelski',
                'cast' => 'Keanu Reeves, Donnie Yen, Bill Skarsgård',
                'genre' => 'Acción',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/vZloFAK7NmvMGKE7VkF5UHaz0I.jpg',
                'trailer_url' => 'https://youtube.com/embed/qEVUtrk8_B4',
                'is_active' => true
            ],
            [
                'title' => 'Black Panther: Wakanda Forever',
                'description' => 'El pueblo de Wakanda lucha para proteger su nación tras la muerte del Rey TChalla.',
                'duration' => 161,
                'release_date' => '2024-11-11',
                'director' => 'Ryan Coogler',
                'cast' => 'Letitia Wright, Lupita Nyongo, Danai Gurira',
                'genre' => 'Acción',
                'poster_url' => 'https://image.tmdb.org/t/p/w500/sv1xJUazXeYqALzczSZ3O6nkH75.jpg',
                'trailer_url' => 'https://youtube.com/embed/RlOB3UALvrQ',
                'is_active' => true
            ]
        ];

        foreach ($movies as $movie) {
            Movie::updateOrCreate(
                ['title' => $movie['title']],
                $movie
            );
        }
    }
}
