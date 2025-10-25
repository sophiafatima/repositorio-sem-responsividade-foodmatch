<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Avaliacao;

class AvaliacaoController extends Controller
{
    public function store(Request $request)
    {
        $avaliacao = Avaliacao::create([
            'nota' => $request->nota,
            'comentario' => $request->comentario
        ]);
        
        return redirect('/avaliacoes')->with('success', 'Avaliação criada com sucesso!');
    }
}
