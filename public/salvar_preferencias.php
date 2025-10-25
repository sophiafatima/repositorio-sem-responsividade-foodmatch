<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $restricoes = implode(',', $input['restricoes'] ?? []);
    $preferencias = implode(',', $input['preferencias'] ?? []);
    
    try {
        $pdo = new PDO('sqlite:../database/database.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Salvar preferências (usando ID 1 como exemplo)
        $stmt = $pdo->prepare("INSERT OR REPLACE INTO preferencias (usuario_id, restricoes, preferencias) VALUES (1, ?, ?)");
        $stmt->execute([$restricoes, $preferencias]);
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>