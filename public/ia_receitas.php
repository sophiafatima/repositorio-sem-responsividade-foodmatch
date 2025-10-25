<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $ingredientes = $input['ingredientes'] ?? '';
    $preferencias = $input['preferencias'] ?? [];
    
    // IA Simples para gerar receitas baseada nos ingredientes
    function gerarReceitaIA($ingredientes, $preferencias) {
        $ingredientesArray = array_map('trim', explode(',', strtolower($ingredientes)));
        
        // Base de conhecimento da IA
        $baseReceitas = [
            'frango' => [
                'nome' => 'Frango Temperado',
                'ingredientes' => ['frango', 'alho', 'limão', 'sal', 'pimenta', 'azeite'],
                'preparo' => "1. Tempere o frango com sal e pimenta\n2. Esprema limão sobre o frango\n3. Adicione alho picado\n4. Regue com azeite\n5. Deixe marinar 30 min\n6. Grelhe ou asse até dourar"
            ],
            'ovo' => [
                'nome' => 'Omelete Especial',
                'ingredientes' => ['ovos', 'sal', 'óleo', 'queijo'],
                'preparo' => "1. Bata os ovos com sal\n2. Aqueça óleo na frigideira\n3. Despeje os ovos\n4. Adicione queijo se tiver\n5. Dobre ao meio\n6. Sirva quente"
            ],
            'macarrão' => [
                'nome' => 'Macarrão Simples',
                'ingredientes' => ['macarrão', 'alho', 'azeite', 'sal'],
                'preparo' => "1. Cozinhe o macarrão em água com sal\n2. Refogue alho no azeite\n3. Misture o macarrão escorrido\n4. Tempere a gosto\n5. Sirva imediatamente"
            ],
            'arroz' => [
                'nome' => 'Arroz Saboroso',
                'ingredientes' => ['arroz', 'alho', 'cebola', 'óleo', 'sal'],
                'preparo' => "1. Refogue alho e cebola no óleo\n2. Adicione o arroz e refogue\n3. Adicione água quente (2:1)\n4. Tempere com sal\n5. Cozinhe até secar\n6. Deixe descansar 5 min"
            ]
        ];
        
        // Encontrar receita baseada nos ingredientes
        $receitaEncontrada = null;
        foreach ($baseReceitas as $ingredienteChave => $receita) {
            if (in_array($ingredienteChave, $ingredientesArray)) {
                $receitaEncontrada = $receita;
                break;
            }
        }
        
        // Se não encontrou, criar receita genérica
        if (!$receitaEncontrada) {
            $receitaEncontrada = [
                'nome' => 'Receita com ' . ucfirst($ingredientesArray[0] ?? 'Ingredientes'),
                'ingredientes' => $ingredientesArray,
                'preparo' => "1. Prepare todos os ingredientes\n2. Tempere a gosto\n3. Cozinhe conforme necessário\n4. Sirva quente"
            ];
        }
        
        // Personalizar baseado nas preferências
        if (isset($preferencias['lactose']) && $preferencias['lactose']) {
            $receitaEncontrada['nome'] .= ' (Sem Lactose)';
        }
        
        if (isset($preferencias['alergia']) && $preferencias['alergia'] && isset($preferencias['alergiaQuais'])) {
            $receitaEncontrada['nome'] .= ' (Sem ' . $preferencias['alergiaQuais'] . ')';
        }
        
        return [
            'nome' => $receitaEncontrada['nome'],
            'ingredientes' => is_array($receitaEncontrada['ingredientes']) ? $receitaEncontrada['ingredientes'] : [$ingredientes],
            'modo_preparo' => $receitaEncontrada['preparo'],
            'tempo_preparo' => '30 min',
            'porcoes' => '2 porções'
        ];
    }
    
    try {
        $receitaGerada = gerarReceitaIA($ingredientes, $preferencias);
        
        // Salvar receita gerada no arquivo
        $timestamp = time();
        $nomeArquivo = $timestamp . '_' . str_replace([' ', '(', ')', ','], ['_', '', '', ''], $receitaGerada['nome']) . '.json';
        
        $dadosReceita = [
            'nome' => $receitaGerada['nome'],
            'receita' => $receitaGerada,
            'data_salvamento' => date('Y-m-d H:i:s')
        ];
        
        // Criar diretório se não existir
        if (!is_dir('storage/receitas')) {
            mkdir('storage/receitas', 0777, true);
        }
        
        file_put_contents("storage/receitas/$nomeArquivo", json_encode($dadosReceita, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo json_encode([
            'success' => true,
            'receita' => $receitaGerada,
            'message' => 'Receita gerada pela IA!'
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro na IA: ' . $e->getMessage()
        ]);
    }
}
?>