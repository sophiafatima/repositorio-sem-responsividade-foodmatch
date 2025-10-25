<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Preferencia;

class PreferenciaSeeder extends Seeder
{
    public function run(): void
    {
        Preferencia::create([
            'usuario_id' => 1,
            'tipo_comida' => 'vegetariana',
            'ingredientes_disponiveis' => 'aveia, banana, leite vegetal',
            'intolerancias' => 'lactose',
            'alergias' => 'amendoim',
        ]);
    }
}
