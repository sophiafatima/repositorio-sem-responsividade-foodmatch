<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;


class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    $this->call([
        UsuarioSeeder::class,
        ReceitaSeeder::class,
        ComentarioSeeder::class,
        PastaSeeder::class,
        FavoritoSeeder::class,
        ParceiroSeeder::class,
        InteracaoIaSeeder::class,
        PostSeeder::class,
        AvaliacaoSeeder::class,
        ListaCompraSeeder::class,
        HistoricoBuscaSeeder::class,
        PreferenciaSeeder::class,
        DoofSeeder::class,
    ]);
}

}
