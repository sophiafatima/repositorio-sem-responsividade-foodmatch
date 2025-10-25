<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Usuario;

Route::post('/teste-cadastro', function(Request $request) {
    try {
        $user = new Usuario();
        $user->nome_usuario = $request->nome_usuario;
        $user->email_usuario = $request->email_usuario;
        $user->senha_usuario = bcrypt($request->senha_usuario);
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Cadastro realizado com sucesso!'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro: ' . $e->getMessage()
        ]);
    }
});