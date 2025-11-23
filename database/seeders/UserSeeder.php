<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        $admin = User::create([
            'name' => 'Administrador Cine',
            'email' => 'admin@cinelaravel.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'birth_date' => '1990-01-01',
        ]);
        $admin->assignRole('admin');

        // Staff
        $staff = User::create([
            'name' => 'Empleado Taquilla',
            'email' => 'staff@cinelaravel.com',
            'password' => Hash::make('password'),
            'phone' => '+0987654321',
            'birth_date' => '1995-05-15',
        ]);
        $staff->assignRole('staff');

        // Client
        $client = User::create([
            'name' => 'Cliente Ejemplo',
            'email' => 'client@cinelaravel.com',
            'password' => Hash::make('password'),
            'phone' => '+1122334455',
            'birth_date' => '2000-10-20',
        ]);
        $client->assignRole('client');
    }
}
