<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hall;

class HallSeeder extends Seeder
{
    public function run()
    {
        $halls = [
            [
                'name' => 'Sala 1 - IMAX',
                'capacity' => 120,
                'rows' => 10,
                'columns' => 12,
                'type' => 'imax', // Valor permitido en el enum
                'features' => 'Pantalla gigante IMAX, sonido envolvente 12.1',
                'is_active' => true
            ],
            [
                'name' => 'Sala 2 - 4DX',
                'capacity' => 100,
                'rows' => 10,
                'columns' => 10,
                'type' => '4dx', // Valor permitido en el enum
                'features' => 'Asientos en movimiento, efectos especiales 4D',
                'is_active' => true
            ],
            [
                'name' => 'Sala 3 - Standard',
                'capacity' => 80,
                'rows' => 8,
                'columns' => 10,
                'type' => 'standard', // Valor permitido en el enum
                'features' => 'Proyección digital, sonido surround 7.1',
                'is_active' => true
            ],
            [
                'name' => 'Sala 4 - Standard Plus',
                'capacity' => 90,
                'rows' => 9,
                'columns' => 10,
                'type' => 'standard', // Valor permitido en el enum
                'features' => 'Butacas premium, proyección láser',
                'is_active' => true
            ]
        ];

        foreach ($halls as $hall) {
            Hall::updateOrCreate(
                ['name' => $hall['name']],
                $hall
            );
        }
    }
}
