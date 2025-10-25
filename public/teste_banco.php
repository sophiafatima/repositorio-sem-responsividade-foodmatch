<?php
echo "<h2>Teste de Conexão com Banco</h2>";

$caminhos = [
    'database/database.sqlite',
    '../database/database.sqlite',
    __DIR__ . '/../database/database.sqlite'
];

foreach ($caminhos as $caminho) {
    echo "<p>Testando caminho: $caminho</p>";
    
    if (file_exists($caminho)) {
        echo "✅ Arquivo existe<br>";
        
        try {
            $pdo = new PDO("sqlite:$caminho");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
            $count = $stmt->fetchColumn();
            
            echo "✅ Conexão OK! Total usuários: $count<br>";
            
            // Testar inserção
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, idioma, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute(['Teste', 'teste@teste.com', '123456', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
            
            if ($result) {
                echo "✅ Inserção OK!<br>";
                // Remover o teste
                $pdo->prepare("DELETE FROM usuarios WHERE email_usuario = 'teste@teste.com'")->execute();
            }
            
            break;
            
        } catch (Exception $e) {
            echo "❌ Erro: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ Arquivo não existe<br>";
    }
    
    echo "<hr>";
}

echo "<br><a href='Cadastro.html'>Ir para Cadastro</a>";
?>