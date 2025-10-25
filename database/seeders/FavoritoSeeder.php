<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorito;

class FavoritoSeeder extends Seeder
{
    public function run(): void
    {
        Favorito::create([
            'id_pasta' => 1,
            'id_receita' => 1,
        ]);
    }
}
