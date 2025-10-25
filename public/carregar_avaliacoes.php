<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $pdo = new PDO('sqlite:../database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT * FROM avaliacoes ORDER BY created_at DESC");
    $avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($avaliacoes);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>