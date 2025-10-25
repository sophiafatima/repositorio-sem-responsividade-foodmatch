<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::create([
            'titulo_post' => 'Dicas de Alimentação Saudável',
            'descricao_post' => 'Descubra como montar pratos equilibrados no seu dia a dia.',
            'id_usuario' => 1,
            'video_url' => 'https://youtube.com/exemplo',
        ]);
    }
}
