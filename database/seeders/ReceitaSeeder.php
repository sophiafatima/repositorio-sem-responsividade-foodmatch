<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Receita;

class ReceitaSeeder extends Seeder
{
    public function run(): void
    {
        Receita::create([
            'nome_receita' => 'Bolo de Cenoura',
            'descricao_receita' => 'Um bolo fofinho com cobertura de chocolate.',
            'ingredientes' => '3 cenouras, 2 xícaras de farinha, 3 ovos, 1 xícara de açúcar, 1/2 xícara de óleo',
            'preferencias' => 'doce',
            'restricao' => false,
        ]);
        
        Receita::create([
            'nome_receita' => 'Salada Caesar',
            'descricao_receita' => 'Salada clássica com alface, croutons e molho caesar.',
            'ingredientes' => 'Alface americana, croutons, queijo parmesão, molho caesar',
            'preferencias' => 'salgado',
            'restricao' => false,
        ]);
        
        Receita::create([
            'nome_receita' => 'Pasta Vegana',
            'descricao_receita' => 'Macarrão com molho de tomate e vegetais.',
            'ingredientes' => 'Macarrão, tomate, abobrinha, berinjela, manjericão',
            'preferencias' => 'vegano',
            'restricao' => true,
        ]);
    }
}
