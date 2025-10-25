<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ReceitaController extends Controller
{
    public function buscarReceita()
    {
        $receita = "Receita de bolo simples";
        session()->push('historico_receitas', $receita);
        return view('storage.app.public.receitas.resultado', compact('receita'));
    }

    private function salvarHistorico($receita)
    {
        session()->push('historico_receitas', $receita);
    }

    public function salvarReceita(Request $request)
    {
        $receita = $request->input('receita');
        $arquivo = storage_path('app/public/receitas/' . time() . '.txt');
        file_put_contents($arquivo, $receita);
        return response()->json(['message' => 'Receita salva com sucesso!', 'arquivo' => $arquivo]);
    }
}
