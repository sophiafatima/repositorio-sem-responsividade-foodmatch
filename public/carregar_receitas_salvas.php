<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $pdo = new PDO('sqlite:../database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT rowid, nome_receita, descricao_receita, created_at FROM receita_salvas ORDER BY created_at DESC");
    $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($receitas);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>