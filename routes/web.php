<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuario;
use App\Models\Receita;

// Rotas para arquivos HTML
Route::get('/', function () {
    return response()->file(public_path('index.html'));
});

Route::get('/login', function () {
    $html = file_get_contents(public_path('Login.html'));
    $html = str_replace('{{ csrf_token() }}', csrf_token(), $html);
    return response($html)->header('Content-Type', 'text/html');
});

Route::get('/cadastro', function () {
    $html = file_get_contents(public_path('Cadastro.html'));
    $token = csrf_token();
    $html = str_replace('{{ csrf_token() }}', $token, $html);
    return response($html)->header('Content-Type', 'text/html');
});

Route::get('/doof', function () {
    $html = file_get_contents(public_path('Doof.html'));
    $html = str_replace('{{ csrf_token() }}', csrf_token(), $html);
    return response($html)->header('Content-Type', 'text/html');
});

// API para login
Route::post('/fazer-login', function (\Illuminate\Http\Request $request) {
    try {
        $user = Usuario::where('email_usuario', $request->email_usuario)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email não encontrado!',
                'debug' => 'Email: ' . $request->email_usuario
            ]);
        }
        
        if (\Hash::check($request->senha_usuario, $user->senha_usuario)) {
            session(['usuario_logado' => $user->nome_usuario]);
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso!',
                'redirect' => '/doof'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Senha incorreta!'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro no login: ' . $e->getMessage()
        ]);
    }
});

// API para cadastro
Route::post('/usuarios', function (\Illuminate\Http\Request $request) {
    try {
        $user = new Usuario();
        $user->nome_usuario = $request->nome_usuario;
        $user->email_usuario = $request->email_usuario;
        $user->senha_usuario = bcrypt($request->senha_usuario);
        $user->save();
        
        session(['usuario_logado' => $user->nome_usuario]);
        
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
})->withoutMiddleware(['csrf']);

// Rotas da IA de receitas
Route::get('/receita/gerar', [App\Http\Controllers\ReceitaController::class, 'gerarReceita']);
Route::get('/receita/salvar', [App\Http\Controllers\ReceitaController::class, 'salvarReceita']);
Route::get('/receita/deletar', [App\Http\Controllers\ReceitaController::class, 'deletarReceita']);
Route::get('/receitas-usuario', [App\Http\Controllers\ReceitaController::class, 'receitasUsuario']);

// API para buscar receitas
Route::get('/api/receitas', function() {
    $receitas = Receita::orderBy('created_at', 'desc')->get();
    return response()->json($receitas);
});

Route::get('/api/receita/{id}', [App\Http\Controllers\ReceitaController::class, 'apiShow']);

// Login GET temporário
Route::get('/login-teste', function(\Illuminate\Http\Request $request) {
    try {
        $user = Usuario::where('email_usuario', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email não encontrado!',
                'debug' => 'Email procurado: ' . $request->email
            ]);
        }
        
        $senhaCheck = \Hash::check($request->senha, $user->senha_usuario);
        
        if ($senhaCheck) {
            session(['usuario_logado' => $user->nome_usuario]);
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso!'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Senha incorreta!',
            'debug' => 'Senha digitada: ' . $request->senha . ' | Hash no banco: ' . substr($user->senha_usuario, 0, 30) . '...'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro no login: ' . $e->getMessage()
        ]);
    }
});

// Cadastro GET temporário
Route::get('/cadastro-teste', function(\Illuminate\Http\Request $request) {
    try {
        $user = new Usuario();
        $user->nome_usuario = $request->nome;
        $user->email_usuario = $request->email;
        $user->senha_usuario = bcrypt($request->senha);
        $user->save();
        
        session(['usuario_logado' => $user->nome_usuario]);
        
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

// Cadastro sem CSRF
Route::post('/cadastro-usuario', function(\Illuminate\Http\Request $request) {
    try {
        $user = new Usuario();
        $user->nome_usuario = $request->nome_usuario;
        $user->email_usuario = $request->email_usuario;
        $user->senha_usuario = bcrypt($request->senha_usuario);
        $user->save();
        
        session(['usuario_logado' => $user->nome_usuario]);
        
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

// Rotas de perfil
Route::get('/perfil', function () {
    $html = file_get_contents(public_path('Perfil.html'));
    $html = str_replace('{{ csrf_token() }}', csrf_token(), $html);
    return response($html)->header('Content-Type', 'text/html');
});

Route::get('/perfil-dados', function() {
    $response = ['success' => false];
    
    // Verificar se é modo de reset de senha
    if (session('reset_email')) {
        $response['reset_mode'] = true;
        $response['reset_email'] = session('reset_email');
    }
    
    if (!session('usuario_logado')) {
        return response()->json($response + ['message' => 'Não logado']);
    }
    
    $usuario = Usuario::where('nome_usuario', session('usuario_logado'))->first();
    return response()->json(['success' => true, 'usuario' => $usuario] + $response);
});

Route::post('/salvar-perfil', function(\Illuminate\Http\Request $request) {
    if (!session('usuario_logado')) {
        return response()->json(['success' => false, 'message' => 'Não logado']);
    }
    
    try {
        $usuario = Usuario::where('nome_usuario', session('usuario_logado'))->first();
        
        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuário não encontrado']);
        }
        
        // Só atualizar campos que não estão vazios
        if ($request->filled('email_usuario')) {
            $usuario->email_usuario = $request->email_usuario;
        }
        if ($request->filled('descricao')) {
            $usuario->descricao = $request->descricao;
        }
        if ($request->filled('restricoes')) {
            $usuario->restricoes = $request->restricoes;
        }
        
        if ($request->hasFile('foto_perfil')) {
            $file = $request->file('foto_perfil');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/fotos'), $filename);
            $usuario->foto_perfil = 'fotos/' . $filename;
        }
        
        $usuario->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Perfil atualizado com sucesso!'
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
});

Route::get('/salvar-perfil-teste', function(\Illuminate\Http\Request $request) {
    if (!session('usuario_logado')) {
        return response()->json(['success' => false, 'message' => 'Não logado']);
    }
    
    try {
        $usuario = Usuario::where('nome_usuario', session('usuario_logado'))->first();
        
        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuário não encontrado: ' . session('usuario_logado')]);
        }
        
        // Só atualizar campos que não estão vazios
        if ($request->filled('email')) {
            $usuario->email_usuario = $request->email;
        }
        if ($request->filled('descricao')) {
            $usuario->descricao = $request->descricao;
        }
        if ($request->filled('restricoes')) {
            $usuario->restricoes = $request->restricoes;
        }
        
        $usuario->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Perfil atualizado com sucesso!',
            'dados_salvos' => [
                'email' => $usuario->email_usuario,
                'descricao' => $usuario->descricao,
                'restricoes' => $usuario->restricoes
            ]
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
});

Route::post('/upload-foto', function(\Illuminate\Http\Request $request) {
    if (!session('usuario_logado')) {
        return response()->json(['success' => false, 'message' => 'Não logado']);
    }
    
    try {
        if ($request->hasFile('foto_perfil')) {
            $usuario = Usuario::where('nome_usuario', session('usuario_logado'))->first();
            
            if (!$usuario) {
                return response()->json(['success' => false, 'message' => 'Usuário não encontrado']);
            }
            
            $file = $request->file('foto_perfil');
            $filename = 'user_' . $usuario->id_usuario . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Criar diretórios se não existirem
            $storagePath = public_path('storage');
            $fotosPath = public_path('storage/fotos');
            
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            if (!file_exists($fotosPath)) {
                mkdir($fotosPath, 0755, true);
            }
            
            if ($file->move($fotosPath, $filename)) {
                $usuario->foto_perfil = 'fotos/' . $filename;
                $usuario->save();
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Foto salva com sucesso!',
                    'foto_url' => '/storage/fotos/' . $filename
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Erro ao mover arquivo']);
            }
        }
        
        return response()->json(['success' => false, 'message' => 'Nenhuma foto enviada']);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
})->withoutMiddleware(['csrf']);

Route::get('/upload-foto-teste', function(\Illuminate\Http\Request $request) {
    if (!session('usuario_logado')) {
        return response()->json(['success' => false, 'message' => 'Não logado']);
    }
    
    try {
        if ($request->foto_base64) {
            $usuario = Usuario::where('nome_usuario', session('usuario_logado'))->first();
            
            if (!$usuario) {
                return response()->json(['success' => false, 'message' => 'Usuário não encontrado']);
            }
            
            // Decodificar base64
            $foto_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto_base64));
            
            if (!$foto_data) {
                return response()->json(['success' => false, 'message' => 'Erro ao decodificar imagem']);
            }
            
            $filename = 'user_' . $usuario->id_usuario . '_' . time() . '.jpg';
            
            // Criar diretórios se não existirem
            $storagePath = public_path('storage');
            $fotosPath = public_path('storage/fotos');
            
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            if (!file_exists($fotosPath)) {
                mkdir($fotosPath, 0755, true);
            }
            
            $filePath = $fotosPath . '/' . $filename;
            
            if (file_put_contents($filePath, $foto_data)) {
                $usuario->foto_perfil = 'fotos/' . $filename;
                $usuario->save();
                
                return response()->json([
                    'success' => true, 
                    'message' => 'Foto salva com sucesso!',
                    'foto_url' => '/storage/fotos/' . $filename,
                    'debug' => [
                        'filename' => $filename,
                        'path' => $filePath,
                        'size' => strlen($foto_data)
                    ]
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Erro ao salvar arquivo']);
            }
        }
        
        return response()->json(['success' => false, 'message' => 'Nenhuma foto enviada']);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
})->withoutMiddleware(['csrf']);

Route::post('/logout', function() {
    session()->forget('usuario_logado');
    return response()->json(['success' => true]);
});

// Rota de teste
Route::get('/teste', function() {
    return '<h1>FoodMatch Funcionando!</h1><a href="/">Home</a> | <a href="/login">Login</a> | <a href="/cadastro">Cadastro</a>';
});

// === SUPORTE AO USUÁRIO ===
Route::get('/suporte', function() {
    return response()->file(public_path('suporte.html'));
});

Route::post('/suporte/ticket', function(\Illuminate\Http\Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Ticket de suporte criado! ID: #' . rand(1000, 9999)
    ]);
})->withoutMiddleware(['csrf']);

// === RECOMENDAÇÕES DE MARCAS ===
Route::get('/api/marcas-recomendadas', function() {
    return response()->json([
        'success' => true,
        'marcas' => [
            ['nome' => 'Taeq', 'categoria' => 'Orgânicos', 'custo_beneficio' => 9],
            ['nome' => 'Qualitá', 'categoria' => 'Básicos', 'custo_beneficio' => 8],
            ['nome' => 'Great Value', 'categoria' => 'Econômicos', 'custo_beneficio' => 9]
        ]
    ]);
});

// === TUTORIAIS DE USUÁRIOS ===
Route::post('/tutorial/upload', function(\Illuminate\Http\Request $request) {
    if (!session('usuario_logado')) {
        return response()->json(['success' => false, 'message' => 'Login necessário']);
    }
    
    return response()->json([
        'success' => true,
        'message' => 'Tutorial enviado para análise!',
        'id' => rand(100, 999)
    ]);
})->withoutMiddleware(['csrf']);

// === COMPARTILHAMENTO ===
Route::get('/compartilhar/{tipo}', function($tipo, \Illuminate\Http\Request $request) {
    $receita = $request->get('receita', 'Receita Deliciosa');
    
    if ($tipo === 'whatsapp') {
        $texto = urlencode("Confira esta receita: $receita - FoodMatch");
        return redirect("https://wa.me/?text=$texto");
    }
    
    if ($tipo === 'email') {
        $assunto = urlencode("Receita: $receita");
        $corpo = urlencode("Confira esta receita incrível no FoodMatch!");
        return redirect("mailto:?subject=$assunto&body=$corpo");
    }
    
    return response()->json(['success' => false, 'message' => 'Tipo inválido']);
});

// === PUBLICIDADE ===
Route::get('/admin/publicidade', function() {
    return response()->json([
        'success' => true,
        'anuncios' => [
            ['id' => 1, 'titulo' => 'Promoção Azeite', 'ativo' => true],
            ['id' => 2, 'titulo' => 'Desconto Temperos', 'ativo' => false]
        ]
    ]);
});

Route::post('/admin/publicidade', function(\Illuminate\Http\Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Anúncio criado com sucesso!'
    ]);
})->withoutMiddleware(['csrf']);

// === FORNECEDORES ===
Route::get('/admin/fornecedores', function() {
    return response()->json([
        'success' => true,
        'fornecedores' => [
            ['id' => 1, 'nome' => 'Distribuidora ABC', 'categoria' => 'Temperos'],
            ['id' => 2, 'nome' => 'Laticínios XYZ', 'categoria' => 'Laticínios']
        ]
    ]);
});

Route::post('/admin/fornecedores', function(\Illuminate\Http\Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Fornecedor cadastrado com sucesso!'
    ]);
})->withoutMiddleware(['csrf']);

// Rota para testar diretório
Route::get('/teste-diretorio', function() {
    $storagePath = public_path('storage');
    $fotosPath = public_path('storage/fotos');
    
    $info = [
        'storage_exists' => file_exists($storagePath),
        'fotos_exists' => file_exists($fotosPath),
        'storage_writable' => is_writable($storagePath),
        'fotos_writable' => is_writable($fotosPath),
        'storage_path' => $storagePath,
        'fotos_path' => $fotosPath
    ];
    
    // Criar diretórios se não existirem
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
        $info['storage_created'] = true;
    }
    if (!file_exists($fotosPath)) {
        mkdir($fotosPath, 0755, true);
        $info['fotos_created'] = true;
    }
    
    return response()->json($info);
});

Route::get('/teste-sessao', function() {
    $usuario = session('usuario_logado');
    return response()->json([
        'sessao' => $usuario ?? 'Nenhuma sessão',
        'todas_sessoes' => session()->all()
    ]);
});

Route::get('/storage/app/receitas_salvas.json', function() {
    return response()->json([]);
});

Route::get('/storage/app/avaliacoes.json', function() {
    return response()->json([]);
});

// Rota para redefinir senha - redireciona para cadastro
Route::get('/redefinir-senha', function(\Illuminate\Http\Request $request) {
    try {
        $user = Usuario::where('email_usuario', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email não encontrado!'
            ]);
        }
        
        // Salvar email na sessão para o cadastro
        session(['reset_email' => $request->email]);
        
        return response()->json([
            'success' => true,
            'redirect' => '/cadastro',
            'message' => 'Redirecionando para atualizar sua senha...'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao processar solicitação: ' . $e->getMessage()
        ]);
    }
});

// Rota para atualizar apenas a senha
Route::post('/atualizar-senha', function(\Illuminate\Http\Request $request) {
    try {
        $email = session('reset_email') ?: $request->email_usuario;
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Email não encontrado na sessão'
            ]);
        }
        
        $user = Usuario::where('email_usuario', $email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ]);
        }
        
        // Atualizar apenas a senha
        $user->senha_usuario = bcrypt($request->senha_usuario);
        $user->save();
        
        // Limpar sessão
        session()->forget('reset_email');
        
        // Fazer login automático
        session(['usuario_logado' => $user->nome_usuario]);
        
        return response()->json([
            'success' => true,
            'message' => 'Senha atualizada com sucesso!',
            'redirect' => '/doof'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao atualizar senha: ' . $e->getMessage()
        ]);
    }
})->withoutMiddleware(['csrf']);

// Rotas de Publicidade
Route::get('/publicidade', [App\Http\Controllers\PublicidadeController::class, 'index']);
Route::post('/publicidade/criar', [App\Http\Controllers\PublicidadeController::class, 'criar']);
Route::get('/publicidade/listar', [App\Http\Controllers\PublicidadeController::class, 'listar']);
Route::put('/publicidade/{id}/status', [App\Http\Controllers\PublicidadeController::class, 'atualizar']);
Route::delete('/publicidade/{id}', [App\Http\Controllers\PublicidadeController::class, 'deletar']);