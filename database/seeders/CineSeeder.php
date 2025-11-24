<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Room;
use App\Models\Showtime;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CineSeeder extends Seeder
{
    public function run()
    {
        // Películas de ejemplo - solo crear si no existen
        $movies = [
            [
                'title' => 'Avengers: Endgame',
                'description' => 'Los Vengadores se reúnen para revertir el snap de Thanos en una épica batalla final.',
                'duration' => 181,
                'genre' => 'Acción, Ciencia Ficción',
                'director' => 'Anthony y Joe Russo',
                'cast' => 'Robert Downey Jr., Chris Evans, Scarlett Johansson, Mark Ruffalo',
                'rating' => 8.4,
                'release_date' => '2024-04-26',
                'is_active' => true,
            ],
            [
                'title' => 'Spider-Man: No Way Home',
                'description' => 'Peter Parker busca ayuda del Doctor Strange para restaurar su identidad secreta.',
                'duration' => 148,
                'genre' => 'Acción, Aventura',
                'director' => 'Jon Watts',
                'cast' => 'Tom Holland, Zendaya, Benedict Cumberbatch, Jacob Batalon',
                'rating' => 8.2,
                'release_date' => '2024-12-17',
                'is_active' => true,
            ],
            [
                'title' => 'Dune: Parte Dos',
                'description' => 'Paul Atreides se une a los Fremen para vengar a su familia y liberar Arrakis.',
                'duration' => 166,
                'genre' => 'Ciencia Ficción, Aventura',
                'director' => 'Denis Villeneuve',
                'cast' => 'Timothée Chalamet, Zendaya, Rebecca Ferguson, Josh Brolin',
                'rating' => 8.7,
                'release_date' => '2024-03-01',
                'is_active' => true,
            ]
        ];

        foreach ($movies as $movieData) {
            Movie::firstOrCreate(
                ['title' => $movieData['title']],
                $movieData
            );
        }

        // Salas de ejemplo
        $rooms = [
            ['name' => 'Sala 1', 'capacity' => 120, 'type' => 'standard', 'features' => 'Sonido Dolby Digital'],
            ['name' => 'Sala 2', 'capacity' => 100, 'type' => 'standard', 'features' => 'Butacas reclinables'],
            ['name' => 'Sala IMAX', 'capacity' => 80, 'type' => 'imax', 'features' => 'Pantalla gigante, Sonido IMAX'],
            ['name' => 'Sala 4DX', 'capacity' => 60, 'type' => '4dx', 'features' => 'Butacas en movimiento, Efectos especiales'],
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate(
                ['name' => $room['name']],
                $room
            );
        }

        // Crear algunas funciones de ejemplo si no existen
        $avengers = Movie::where('title', 'Avengers: Endgame')->first();
        $spiderman = Movie::where('title', 'Spider-Man: No Way Home')->first();
        $sala1 = Room::where('name', 'Sala 1')->first();
        $salaImax = Room::where('name', 'Sala IMAX')->first();

        if ($avengers && $sala1) {
            Showtime::firstOrCreate([
                'movie_id' => $avengers->id,
                'room_id' => $sala1->id,
                'start_time' => Carbon::tomorrow()->setHour(18)->setMinute(0),
            ], [
                'end_time' => Carbon::tomorrow()->setHour(21)->setMinute(1),
                'price' => 12.50,
                'available_seats' => $sala1->capacity,
                'format' => '2D',
                'language' => 'Español',
                'is_active' => true,
            ]);
        }

        if ($spiderman && $salaImax) {
            Showtime::firstOrCreate([
                'movie_id' => $spiderman->id,
                'room_id' => $salaImax->id,
                'start_time' => Carbon::tomorrow()->setHour(20)->setMinute(0),
            ], [
                'end_time' => Carbon::tomorrow()->setHour(22)->setMinute(28),
                'price' => 18.00,
                'available_seats' => $salaImax->capacity,
                'format' => 'IMAX',
                'language' => 'Inglés subtitulada',
                'is_active' => true,
            ]);
        }
    }
}
