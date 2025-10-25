<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasta;

class PastaSeeder extends Seeder
{
    public function run(): void
    {
        Pasta::create([
            'id_usuario' => 1,
            'nome' => 'Minhas Receitas Favoritas',
        ]);
    }
}
