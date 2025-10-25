<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parceiro;

class ParceiroSeeder extends Seeder
{
    public function run(): void
    {
        Parceiro::create([
            'nome' => 'NutriVida',
            'tipo' => 'Nutricionista',
            'email' => 'contato@nutrivida.com',
            'telefone' => '(11) 99999-8888',
            'descricao' => 'Consultoria de alimentação saudável',
            'site_url' => 'https://nutrivida.com',
        ]);
    }
}
