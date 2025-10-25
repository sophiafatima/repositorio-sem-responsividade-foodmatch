<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $ingredientes = $input['ingredientes'] ?? '';
    $porcoes = $input['porcoes'] ?? 2;
    $preferencias = $input['preferencias'] ?? '';
    

    $receitas_mockadas = [
        [
            'nome' => 'Frango Grelhado',
            'ingredientes' => ['1 peito de frango grande', '3 dentes de alho', '1 limão', 'sal a gosto', 'pimenta do reino', '2 colheres de azeite'],
            'modo_preparo' => "1. Corte o peito de frango ao meio na horizontal\n2. Tempere com sal e pimenta dos dois lados\n3. Esprema o limão sobre o frango\n4. Amasse o alho e espalhe sobre a carne\n5. Regue com azeite\n6. Deixe marinar por 30 minutos\n7. Aqueça a grelha ou frigideira\n8. Grelhe o frango por 8 minutos de cada lado\n9. Verifique se está bem cozido por dentro\n10. Deixe descansar 5 minutos antes de servir",
            'tempo_preparo' => '45 min',
            'porcoes' => '2 porções',
            'categoria' => 'carne'
        ],
        [
            'nome' => 'Macarrão à Carbonara',
            'ingredientes' => ['500g macarrão', '200g bacon', '3 ovos', '100g queijo parmesão', 'pimenta', 'sal'],
            'modo_preparo' => "1. Coloque água para ferver em panela grande com sal\n2. Cozinhe o macarrão al dente conforme instruções da embalagem\n3. Corte o bacon em cubos pequenos\n4. Frite o bacon em frigideira até ficar dourado e crocante\n5. Em tigela, bata os ovos com queijo ralado\n6. Escorra o macarrão reservando um pouco da água do cozimento\n7. Misture o macarrão quente com bacon na frigideira\n8. Retire do fogo e adicione a mistura de ovos mexendo rapidamente\n9. Se necessário, adicione água do cozimento para cremosidade\n10. Tempere com pimenta do reino e sirva imediatamente",
            'tempo_preparo' => '25 min',
            'porcoes' => '4 porções',
            'categoria' => 'massa'
        ],
        [
            'nome' => 'Salada Caesar',
            'ingredientes' => ['1 pé de alface americana', '100g croutons', '50g queijo parmesão', 'molho caesar', 'anchovas (opcional)'],
            'modo_preparo' => "1. Lave e corte a alface em pedaços médios\n2. Coloque a alface em uma saladeira grande\n3. Adicione os croutons por cima\n4. Regue com molho caesar\n5. Polvilhe o queijo parmesão ralado\n6. Adicione anchovas se desejar\n7. Misture delicadamente\n8. Sirva imediatamente",
            'tempo_preparo' => '10 min',
            'porcoes' => '2 porções',
            'categoria' => 'salada'
        ],
        [
            'nome' => 'Sorvete de Manga',
            'ingredientes' => ['2 mangas maduras', '1 lata de leite condensado', '1 copo de leite', '1 envelope de gelatina incolor'],
            'modo_preparo' => "1. Descasque e corte as mangas em pedaços\n2. Bata no liquidificador a manga, leite condensado e leite\n3. Dissolva a gelatina em água quente conforme instruções\n4. Adicione a gelatina dissolvida à mistura\n5. Bata novamente por 2 minutos\n6. Despeje em recipiente e leve ao freezer\n7. Mexa a cada 30 minutos nas primeiras 2 horas\n8. Deixe congelar por pelo menos 4 horas\n9. Sirva gelado",
            'tempo_preparo' => '20 min + 4h congelamento',
            'porcoes' => '6 porções',
            'categoria' => 'sobremesa'
        ],
        [
            'nome' => 'Sorvete de Manga Vegano',
            'ingredientes' => ['3 mangas maduras congeladas', '1 lata de leite de coco', '3 colheres de açúcar demerara', '1 colher de suco de limão'],
            'modo_preparo' => "1. Descasque e corte as mangas em cubos, congele por 2 horas\n2. No liquidificador, bata as mangas congeladas\n3. Adicione o leite de coco aos poucos\n4. Acrescente o açúcar demerara\n5. Adicione o suco de limão para realzar o sabor\n6. Bata até obter consistência cremosa\n7. Prove e ajuste a doçura se necessário\n8. Sirva imediatamente ou congele por 1 hora para ficar mais firme",
            'tempo_preparo' => '15 min + 2h congelamento',
            'porcoes' => '4 porções',
            'categoria' => 'sobremesa',
            'vegano' => true
        ],
        [
            'nome' => 'Sorvete de Manga Sem Lactose',
            'ingredientes' => ['2 mangas maduras', '1 lata de leite condensado sem lactose', '1 copo de leite sem lactose', '1 envelope de gelatina incolor'],
            'modo_preparo' => "1. Descasque e corte as mangas em pedaços\n2. Bata no liquidificador a manga, leite condensado sem lactose e leite sem lactose\n3. Dissolva a gelatina em água quente conforme instruções\n4. Adicione a gelatina dissolvida à mistura\n5. Bata novamente por 2 minutos\n6. Despeje em recipiente e leve ao freezer\n7. Mexa a cada 30 minutos nas primeiras 2 horas\n8. Deixe congelar por pelo menos 4 horas\n9. Sirva gelado",
            'tempo_preparo' => '20 min + 4h congelamento',
            'porcoes' => '6 porções',
            'categoria' => 'sobremesa',
            'sem_lactose' => true
        ],
        [
            'nome' => 'Smoothie de Frutas',
            'ingredientes' => ['1 banana', '1/2 manga', '1 maçã', '200ml leite vegetal', '1 colher mel', 'gelo'],
            'modo_preparo' => "1. Descasque e corte todas as frutas\n2. Coloque no liquidificador\n3. Adicione o leite vegetal\n4. Adicione mel a gosto\n5. Bata até ficar cremoso\n6. Adicione gelo e bata mais um pouco\n7. Sirva imediatamente",
            'tempo_preparo' => '5 min',
            'porcoes' => '2 porções',
            'categoria' => 'bebida'
        ]
    ];
    

    $ingredientes_lower = strtolower($ingredientes);
    $receita_selecionada = null;
    
    $preferencias_usuario = json_decode($preferencias, true) ?? [];
    $eh_vegano = isset($preferencias_usuario['vegano']) && $preferencias_usuario['vegano'];
    $sem_lactose = isset($preferencias_usuario['lactose']) && $preferencias_usuario['lactose'];
    
    foreach ($receitas_mockadas as $receita) {
        $nome_lower = strtolower($receita['nome']);
        
        if (strpos($ingredientes_lower, 'sorvete') !== false && strpos($ingredientes_lower, 'manga') !== false) {
            if ($receita['categoria'] === 'sobremesa') {
                if ($eh_vegano && isset($receita['vegano']) && $receita['vegano']) {
                    $receita_selecionada = $receita;
                    break;
                } elseif ($sem_lactose && isset($receita['sem_lactose']) && $receita['sem_lactose']) {
                    $receita_selecionada = $receita;
                    break;
                } elseif (!$eh_vegano && !$sem_lactose && !isset($receita['vegano']) && !isset($receita['sem_lactose'])) {
                    $receita_selecionada = $receita;
                    break;
                }
            }
        } elseif (strpos($ingredientes_lower, 'smoothie') !== false || strpos($ingredientes_lower, 'vitamina') !== false) {
            if ($receita['categoria'] === 'bebida') {
                $receita_selecionada = $receita;
                break;
            }
        } elseif (strpos($ingredientes_lower, 'frango') !== false || strpos($ingredientes_lower, 'carne') !== false) {
            if ($receita['categoria'] === 'carne' && !$eh_vegano) {
                $receita_selecionada = $receita;
                break;
            }
        } elseif (strpos($ingredientes_lower, 'massa') !== false || strpos($ingredientes_lower, 'macarrão') !== false) {
            if ($receita['categoria'] === 'massa' && !$eh_vegano) {
                $receita_selecionada = $receita;
                break;
            }
        } elseif (strpos($ingredientes_lower, 'salada') !== false || strpos($ingredientes_lower, 'alface') !== false) {
            if ($receita['categoria'] === 'salada') {
                $receita_selecionada = $receita;
                break;
            }
        }
    }
    
    if (!$receita_selecionada) {
        if ($eh_vegano) {
            $receitas_veganas = array_filter($receitas_mockadas, function($r) {
                return isset($r['vegano']) && $r['vegano'] || $r['categoria'] === 'salada' || $r['categoria'] === 'bebida';
            });
            $receita_selecionada = $receitas_veganas ? $receitas_veganas[array_rand($receitas_veganas)] : $receitas_mockadas[3];
        } else {
            $receita_selecionada = $receitas_mockadas[array_rand($receitas_mockadas)];
        }
    }
    
    if ($porcoes != $receita_selecionada['porcoes']) {
        $fator = $porcoes / (int)filter_var($receita_selecionada['porcoes'], FILTER_SANITIZE_NUMBER_INT);
        $receita_selecionada['porcoes'] = $porcoes . ' porções';
    }
    

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
        

        if (!is_dir('storage/receitas')) {
            mkdir('storage/receitas', 0777, true);
        }
        file_put_contents("storage/receitas/$nomeArquivo", json_encode($dadosReceita, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        

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
            'success' => true,
            'receita' => $receita_selecionada,
            'warning' => 'Receita gerada mas não salva: ' . $e->getMessage()
        ]);
    }
}
?>