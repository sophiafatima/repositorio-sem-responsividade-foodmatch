<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoricoBusca;

class HistoricoBuscaSeeder extends Seeder
{
    public function run(): void
    {
        HistoricoBusca::create([
            'usuario_id' => 1,
            'receita_id' => 1,
            'termo_busca' => 'bolo de cenoura',
        ]);
    }
}
