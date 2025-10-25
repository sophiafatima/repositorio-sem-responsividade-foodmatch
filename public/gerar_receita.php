<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $ingredientes = $input['ingredientes'] ?? '';
    $preferencias = $input['preferencias'] ?? '';
    
    // Simular chamada para API de receitas (você pode integrar com uma API real depois)
    $receitas_mockadas = [
        [
            'nome' => 'Frango Grelhado',
            'ingredientes' => ['1 peito de frango grande', '3 dentes de alho', '1 limão', 'sal a gosto', 'pimenta do reino', '2 colheres de azeite'],
            'modo_preparo' => "1. Corte o peito de frango ao meio na horizontal\n2. Tempere com sal e pimenta dos dois lados\n3. Esprema o limão sobre o frango\n4. Amasse o alho e espalhe sobre a carne\n5. Regue com azeite\n6. Deixe marinar por 30 minutos\n7. Aqueça a grelha ou frigideira\n8. Grelhe o frango por 8 minutos de cada lado\n9. Verifique se está bem cozido por dentro\n10. Deixe descansar 5 minutos antes de servir",
            'tempo_preparo' => '45 min',
            'porcoes' => '2 porções'
        ],
        [
            'nome' => 'Macarrão à Carbonara',
            'ingredientes' => ['500g macarrão', '200g bacon', '3 ovos', '100g queijo parmesão', 'pimenta', 'sal'],
            'modo_preparo' => "1. Coloque água para ferver em panela grande com sal\n2. Cozinhe o macarrão al dente conforme instruções da embalagem\n3. Corte o bacon em cubos pequenos\n4. Frite o bacon em frigideira até ficar dourado e crocante\n5. Em tigela, bata os ovos com queijo ralado\n6. Escorra o macarrão reservando um pouco da água do cozimento\n7. Misture o macarrão quente com bacon na frigideira\n8. Retire do fogo e adicione a mistura de ovos mexendo rapidamente\n9. Se necessário, adicione água do cozimento para cremosidade\n10. Tempere com pimenta do reino e sirva imediatamente",
            'tempo_preparo' => '25 min',
            'porcoes' => '4 porções'
        ],
        [
            'nome' => 'Salada Caesar',
            'ingredientes' => ['1 pé de alface americana', '100g croutons', '50g queijo parmesão', 'molho caesar', 'anchovas (opcional)'],
            'modo_preparo' => "1. Lave e corte a alface em pedaços médios\n2. Coloque a alface em uma saladeira grande\n3. Adicione os croutons por cima\n4. Regue com molho caesar\n5. Polvilhe o queijo parmesão ralado\n6. Adicione anchovas se desejar\n7. Misture delicadamente\n8. Sirva imediatamente",
            'tempo_preparo' => '10 min',
            'porcoes' => '2 porções'
        ]
    ];
    
    // Selecionar receita baseada nos ingredientes ou aleatória
    $receita_selecionada = $receitas_mockadas[array_rand($receitas_mockadas)];
    
    // Salvar receita gerada
    try {
        $pdo = new PDO('sqlite:../database/database.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $timestamp = time();
        $nomeArquivo = $timestamp . '_' . str_replace(' ', '_', $receita_selecionada['nome']) . '.json';
        
        $dadosReceita = [
            'nome' => $receita_selecionada['nome'],
            'receita' => $receita_selecionada,
            'data_salvamento' => date('Y-m-d H:i:s')
        ];
        
        // Salvar no arquivo JSON
        if (!is_dir('storage/receitas')) {
            mkdir('storage/receitas', 0777, true);
        }
        file_put_contents("storage/receitas/$nomeArquivo", json_encode($dadosReceita, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        // Salvar no banco
        $stmt = $pdo->prepare("INSERT INTO receitas (nome_receita, descricao_receita, ingredientes, preferencias, restricao, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $ingredientes_str = implode(', ', $receita_selecionada['ingredientes']);
        $stmt->execute([
            $receita_selecionada['nome'],
            $receita_selecionada['modo_preparo'],
            $ingredientes_str,
            $preferencias ?: 'geral',
            0,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        
        echo json_encode([
            'success' => true,
            'receita' => $receita_selecionada
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => true, // Retornar sucesso mesmo se não salvar no banco
            'receita' => $receita_selecionada,
            'warning' => 'Receita gerada mas não salva: ' . $e->getMessage()
        ]);
    }
}
?>