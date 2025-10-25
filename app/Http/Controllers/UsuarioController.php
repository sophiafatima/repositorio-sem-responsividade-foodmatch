<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function store(Request $request)
    {
        $usuario = Usuario::create([
            'nome_usuario' => $request->nome,
            'email_usuario' => $request->email,
            'senha_usuario' => bcrypt($request->senha)
        ]);
        
        return redirect('/usuarios')->with('success', 'Usuário criado com sucesso!');
    }
}
