<?php
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Importando dados dos arquivos JSON...</h2>";
    
    // Importar receitas
    $receitasDir = 'storage/receitas/';
    if (is_dir($receitasDir)) {
        $files = glob($receitasDir . '*.json');
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $data = json_decode($content, true);
            
            if ($data && isset($data['receita'])) {
                $receita = $data['receita'];
                
                // Verificar se já existe
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM receitas WHERE nome_receita = ?");
                $stmt->execute([$receita['nome']]);
                
                if ($stmt->fetchColumn() == 0) {
                    $stmt = $pdo->prepare("INSERT INTO receitas (nome_receita, descricao_receita, ingredientes, preferencias, restricao, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    
                    $ingredientes = is_array($receita['ingredientes']) ? implode(', ', $receita['ingredientes']) : $receita['ingredientes'];
                    $descricao = $receita['modo_preparo'] ?? 'Modo de preparo não informado';
                    
                    $stmt->execute([
                        $receita['nome'],
                        $descricao,
                        $ingredientes,
                        'geral',
                        0,
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s')
                    ]);
                    
                    echo "✅ Receita importada: " . $receita['nome'] . "<br>";
                } else {
                    echo "⚠️ Receita já existe: " . $receita['nome'] . "<br>";
                }
            }
        }
    }
    
    // Verificar dados importados
    $receitasCount = $pdo->query("SELECT COUNT(*) FROM receitas")->fetchColumn();
    echo "<br><strong>Total de receitas no banco: $receitasCount</strong><br>";
    
    // Listar receitas
    echo "<h3>Receitas no banco:</h3>";
    $stmt = $pdo->query("SELECT * FROM receitas");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $row['nome_receita'] . "<br>";
    }
    
    echo "<br><a href='Doof.html'>Ir para o Doof</a>";
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>