<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ListaDeCompra;

class ListaDeCompraController extends Controller
{
    public function store(Request $request)
    {
        $lista = ListaDeCompra::create([
            'nome' => $request->nome,
            'itens' => $request->itens
        ]);
        
        return redirect('/lista-de-compras')->with('success', 'Lista de compras criada com sucesso!');
    }
}
