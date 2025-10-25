<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuario;
use App\Models\Receita;
use App\Models\Post;
use App\Models\Avaliacao;
use App\Models\ReceitaSalva;
use App\Models\ListaDeCompra;

// Rota principal
Route::get('/', function () {
    return response()->file(public_path('index.html'));
});

// Rotas de usuários
Route::get('/usuarios', function () {
    $usuarios = Usuario::all();
    return view('usuarios.index', compact('usuarios'));
});



// Rotas de posts
Route::get('/posts', function () {
    $posts = Post::all();
    return view('Posts.index', compact('posts'));
});

// Rotas de páginas
Route::get('/cadastro', function () {
    return view('cadastro.index');
});

Route::get('/doof', function () {
    $receitas = \App\Models\Receita::orderBy('created_at', 'desc')->get();
    return view('doof.index', compact('receitas'));
});

Route::get('/index', function () {
    return response()->file(public_path('index.html'));
});

Route::get('/login', function () {
    return view('login.index');
});

Route::get('/perfil', function () {
    return response()->file(public_path('Perfil.html'));
});

Route::get('/posts', function () {
    return response()->file(public_path('Posts.html'));
});

Route::get('/usuario/perfil', function () {
    return view('usuario.perfil');
});

Route::post('/usuario/perfil', function (\Illuminate\Http\Request $request) {
    session([
        'perfil_nome' => $request->nome,
        'perfil_email' => $request->email,
        'perfil_descricao' => $request->descricao,
        'perfil_preferencias' => $request->preferencias ?: []
    ]);
    
    if ($request->hasFile('foto')) {
        $foto = $request->file('foto');
        $nomeArquivo = time() . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('uploads'), $nomeArquivo);
        session(['perfil_foto' => asset('uploads/' . $nomeArquivo)]);
    }
    
    return redirect('/usuario/perfil')->with('success', 'Perfil atualizado!');
});

// Rotas para receitas
Route::get('/receitas', [App\Http\Controllers\ReceitaController::class, 'index']);
Route::get('/receitas/{id}', [App\Http\Controllers\ReceitaController::class, 'show']);
Route::post('/receitas', [App\Http\Controllers\ReceitaController::class, 'store']);

// Rotas de receitas
Route::post('/receita/gerar', [App\Http\Controllers\ReceitaController::class, 'gerarReceita']);
Route::post('/receita/salvar', [App\Http\Controllers\ReceitaController::class, 'salvarReceita']);
Route::post('/receita/deletar', [App\Http\Controllers\ReceitaController::class, 'deletarReceita']);

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/receitas', [App\Http\Controllers\ReceitaController::class, 'index']);
    Route::get('/receita/{id}', [App\Http\Controllers\ReceitaController::class, 'apiShow']);
    Route::post('/receitas/gerar', [App\Http\Controllers\ReceitaController::class, 'gerarReceita']);
    Route::post('/receitas/salvar', [App\Http\Controllers\ReceitaController::class, 'salvarReceita']);
    Route::delete('/receitas/{id}', [App\Http\Controllers\ReceitaController::class, 'deletarReceita']);
});
Route::post('/pasta/salvar', [App\Http\Controllers\ReceitaController::class, 'salvarPasta']);
Route::post('/avaliacao/salvar', [App\Http\Controllers\ReceitaController::class, 'salvarAvaliacao']);
Route::post('/comentario/salvar', [App\Http\Controllers\ReceitaController::class, 'salvarComentario']);
Route::post('/denuncia/salvar', [App\Http\Controllers\ReceitaController::class, 'salvarDenuncia']);
Route::get('/receitas/salvas', function() { return view('receitas.simples'); });
Route::get('/receitas/avaliadas', function() { return view('receitas.avaliadas'); });
Route::get('/receitas/teste', function() {
    $arquivoReceitas = storage_path('app/receitas_salvas.json');
    $existe = file_exists($arquivoReceitas);
    $receitas = [];
    if ($existe) {
        $receitas = json_decode(file_get_contents($arquivoReceitas), true) ?: [];
    }
    return 'Arquivo existe: ' . ($existe ? 'SIM' : 'NAO') . '<br>Total: ' . count($receitas) . '<br>Caminho: ' . $arquivoReceitas;
});

// Rota para processar login
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $user = \App\Models\Usuario::where('email_usuario', $request->email_usuario)->first();
    
    if ($user && \Hash::check($request->senha_usuario, $user->senha_usuario)) {
        session(['usuario_logado' => $user->nome_usuario]);
        return redirect('/doof')->with('success', 'Login realizado com sucesso!');
    }
    
    return redirect('/login')->with('error', 'Email ou senha incorretos!');
});

// Rota para logout
Route::post('/logout', function () {
    session()->forget('usuario_logado');
    return redirect('/')->with('success', 'Logout realizado com sucesso!');
});

// Rota para processar cadastro
Route::post('/usuarios', function (\Illuminate\Http\Request $request) {
    try {
        \App\Models\Usuario::where('email_usuario', $request->email_usuario)->delete();
        
        $user = new \App\Models\Usuario();
        $user->nome_usuario = $request->nome_usuario;
        $user->email_usuario = $request->email_usuario;
        $user->senha_usuario = bcrypt($request->senha_usuario);
        $user->save();
        
        session(['usuario_logado' => $user->nome_usuario]);
        
        return redirect('/doof')->with('success', 'Cadastro realizado com sucesso!');
        
    } catch (\Exception $e) {
        return redirect('/cadastro')->with('error', 'Erro: ' . $e->getMessage());
    }
});