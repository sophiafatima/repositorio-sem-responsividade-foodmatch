<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $pdo = new PDO('sqlite:../database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT * FROM receitas ORDER BY created_at DESC LIMIT 10");
    $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($receitas);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>