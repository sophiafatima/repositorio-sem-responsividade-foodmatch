<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListaDeCompra;

class ListaCompraSeeder extends Seeder
{
    public function run(): void
    {
        ListaDeCompra::create([
            'usuario_id' => 1,
            'receita_id' => 1,
            'ingrediente' => 'Farinha de trigo',
            'quantidade' => '2 xícaras',
        ]);
    }
}
