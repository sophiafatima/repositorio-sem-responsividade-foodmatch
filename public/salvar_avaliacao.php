<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $receita = $input['receita'] ?? '';
    $nota = $input['nota'] ?? 0;
    $comentario = $input['comentario'] ?? '';
    $usuario = $input['usuario'] ?? 'Usuário';
    
    try {
        $pdo = new PDO('sqlite:../database/database.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Salvar avaliação no banco
        $stmt = $pdo->prepare("INSERT INTO avaliacoes (id_usuario, nota, comentario, nome_usuario, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            1, // ID do usuário (simulado)
            $nota,
            $comentario,
            $usuario,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        
        // Salvar também no arquivo JSON
        $arquivoAvaliacoes = '../storage/app/avaliacoes.json';
        $avaliacoes = [];
        if (file_exists($arquivoAvaliacoes)) {
            $avaliacoes = json_decode(file_get_contents($arquivoAvaliacoes), true) ?: [];
        }
        
        $avaliacoes[] = [
            'receita_id' => 1,
            'nome_receita' => $receita,
            'estrelas' => $nota,
            'comentario' => $comentario,
            'curtida' => true,
            'descurtida' => false,
            'data_avaliacao' => date('Y-m-d H:i:s'),
            'usuario' => $usuario
        ];
        
        file_put_contents($arquivoAvaliacoes, json_encode($avaliacoes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo json_encode(['success' => true, 'message' => 'Avaliação salva com sucesso!']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
}
?>