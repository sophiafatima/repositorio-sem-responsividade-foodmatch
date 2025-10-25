<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $receita = $input['receita'] ?? null;
    
    if (!$receita) {
        echo json_encode(['success' => false, 'message' => 'Dados da receita não fornecidos']);
        exit;
    }
    
    try {
        $pdo = new PDO('sqlite:../database/database.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verificar se já existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM receita_salvas WHERE nome_receita = ?");
        $stmt->execute([$receita['nome']]);
        
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Receita já está salva!']);
            exit;
        }
        
        // Salvar receita
        $stmt = $pdo->prepare("INSERT INTO receita_salvas (id_receita, id_usuario, nome_receita, descricao_receita, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            1, // ID da receita (simulado)
            1, // ID do usuário (simulado)
            $receita['nome'],
            $receita['modo_preparo'] ?? 'Sem descrição',
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        
        // Salvar também no arquivo JSON
        $arquivoReceitas = '../storage/app/receitas_salvas.json';
        $receitas = [];
        if (file_exists($arquivoReceitas)) {
            $receitas = json_decode(file_get_contents($arquivoReceitas), true) ?: [];
        }
        
        $receitas[] = [
            'nome' => $receita['nome'],
            'receita' => $receita,
            'data_salvamento' => date('Y-m-d H:i:s')
        ];
        
        file_put_contents($arquivoReceitas, json_encode($receitas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo json_encode(['success' => true, 'message' => 'Receita salva com sucesso!']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
}
?>