<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comentario;

class ComentarioSeeder extends Seeder
{
    public function run(): void
    {
        Comentario::create([
            'id_receita' => 1,
            'id_usuario' => 1,
            'texto' => 'Essa receita ficou perfeita!',
        ]);
    }
}
