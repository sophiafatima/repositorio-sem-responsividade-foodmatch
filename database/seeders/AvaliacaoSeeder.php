<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avaliacao;

class AvaliacaoSeeder extends Seeder
{
    public function run(): void
    {
        Avaliacao::create([
            'id_usuario' => 1,
            'id_receita' => 1,
            'nota' => 5,
            'comentario' => 'Simplesmente deliciosa!',
        ]);
    }
}
