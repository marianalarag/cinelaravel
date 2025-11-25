<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Ejecutar seeders en el orden correcto
        $this->call([
            RoleSeeder::class,     // Primero roles
            UserSeeder::class,     // Luego usuarios (depende de roles)
            GenreSeeder::class,    // Luego géneros
            MovieSeeder::class,    // Luego películas (depende de géneros)
            RoomSeeder::class,     // Luego salas (rooms)
            ShowtimeSeeder::class, // Finalmente funciones (depende de películas y salas)
        ]);

        $this->command->info('=== DATABASE SEEDED SUCCESSFULLY ===');
        $this->command->info('Admin: admin@cinelaravel.com / password');
        $this->command->info('Staff: staff@cinelaravel.com / password');
        $this->command->info('Client: cliente@cinelaravel.com / password');
    }
}
