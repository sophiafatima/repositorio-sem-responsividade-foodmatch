<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nome_usuario' => 'Sophia Almeida',
            'email_usuario' => 'sophia@example.com',
            'senha_usuario' => bcrypt('123456'),
        ]);

        Usuario::create([
            'nome_usuario' => 'Admin',
            'email_usuario' => 'admin@foodmatch.com',
            'senha_usuario' => bcrypt('admin123'),
        ]);
    }
}
