<?php
echo "<h2>Teste de Cadastro</h2>";

// Simular dados de cadastro
$dados = [
    'nome' => 'Teste Usuario',
    'email' => 'teste@exemplo.com',
    'senha' => '123456'
];

// Fazer requisição para cadastro_process.php
$postData = json_encode($dados);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $postData
    ]
]);

$result = file_get_contents('http://localhost:8000/cadastro_process.php', false, $context);
echo "<p>Resultado do cadastro: " . $result . "</p>";

// Testar login
$loginData = [
    'email' => 'teste@exemplo.com',
    'senha' => '123456'
];

$postData = json_encode($loginData);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $postData
    ]
]);

$result = file_get_contents('http://localhost:8000/login_process.php', false, $context);
echo "<p>Resultado do login: " . $result . "</p>";

echo "<br><a href='Cadastro.html'>Ir para Cadastro</a>";
echo "<br><a href='Login.html'>Ir para Login</a>";
?>