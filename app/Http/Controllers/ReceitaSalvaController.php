<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReceitaSalva;

class ReceitaSalvaController extends Controller
{
    public function store(Request $request)
    {
        $receitaSalva = ReceitaSalva::create([
            'receita_id' => $request->receita_id,
            'usuario_id' => $request->usuario_id
        ]);
        
        return redirect('/receita-salvas')->with('success', 'Receita salva com sucesso!');
    }
}
