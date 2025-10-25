<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $post = Post::create([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo
        ]);
        
        return redirect('/posts')->with('success', 'Post criado com sucesso!');
    }
}
