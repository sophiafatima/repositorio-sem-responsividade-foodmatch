<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $senha = $input['senha'] ?? '';
    

    try {
        $pdo = new PDO('sqlite:../database/database.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            echo json_encode([
                'success' => false,
                'message' => 'Email não cadastrado. Por favor, cadastre-se primeiro.'
            ]);
        } else if ($usuario['senha_usuario'] === $senha) {
            echo json_encode([
                'success' => true,
                'redirect' => '/doof'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Senha incorreta.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro no servidor: ' . $e->getMessage()
        ]);
    }
}
?>