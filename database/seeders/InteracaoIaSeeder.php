<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InteracaoIa;

class InteracaoIaSeeder extends Seeder
{
    public function run(): void
    {
        InteracaoIa::create([
            'id_usuario' => 1,
            'prompt' => 'Gerar receita com banana e aveia',
            'resposta' => 'Experimente fazer panquecas de banana com aveia!',
        ]);
    }
}
    