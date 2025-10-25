<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $nome = $input['nome'] ?? '';
    $email = $input['email'] ?? '';
    $senha = $input['senha'] ?? '';
    
    try {
        $pdo = new PDO('sqlite:database/database.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verificar se email já existe
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email já cadastrado!']);
            exit;
        }
        
        // Inserir usuário
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, idioma, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senha, 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        
        echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
}
?>