<?php
try {
    $pdo = new PDO('sqlite:../database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, idioma) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Teste User', 'teste@teste.com', '123456', 1]);
    
    echo "Usuário criado com sucesso!<br>";
    echo "Email: teste@teste.com<br>";
    echo "Senha: 123456<br>";
    echo "<a href='Login.html'>Ir para Login</a>";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>