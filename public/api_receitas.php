<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

function buscarReceitasAPI($ingredientes) {
    $ingredientesStr = implode(',', $ingredientes);
    $apiKey = 'SUA_API_KEY_AQUI'; // Substitua pela sua chave da API
    
    // Usando API do Spoonacular como exemplo
    $url = "https://api.spoonacular.com/recipes/findByIngredients?ingredients={$ingredientesStr}&number=5&apiKey={$apiKey}";
    
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Content-Type: application/json'
        ]
    ]);
    
    $response = file_get_contents($url, false, $context);
    return json_decode($response, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $ingredientes = $input['ingredientes'] ?? [];
    
    if (empty($ingredientes)) {
        // Receitas padrão se não houver ingredientes
        $receitas = [
            [
                'id' => 1,
                'title' => 'Omelete Simples',
                'image' => 'https://via.placeholder.com/300x200',
                'usedIngredients' => [['name' => 'ovos'], ['name' => 'sal']],
                'missedIngredients' => []
            ],
            [
                'id' => 2,
                'title' => 'Salada Verde',
                'image' => 'https://via.placeholder.com/300x200',
                'usedIngredients' => [['name' => 'alface'], ['name' => 'tomate']],
                'missedIngredients' => []
            ],
            [
                'id' => 3,
                'title' => 'Macarrão ao Alho',
                'image' => 'https://via.placeholder.com/300x200',
                'usedIngredients' => [['name' => 'macarrão'], ['name' => 'alho']],
                'missedIngredients' => []
            ]
        ];
    } else {
        // Tentar buscar na API real (descomente quando tiver a chave)
        // $receitas = buscarReceitasAPI($ingredientes);
        
        // Por enquanto, receitas mockadas baseadas nos ingredientes
        $receitas = [
            [
                'id' => 1,
                'title' => 'Receita com ' . implode(' e ', array_slice($ingredientes, 0, 2)),
                'image' => 'https://via.placeholder.com/300x200',
                'usedIngredients' => array_map(fn($ing) => ['name' => $ing], $ingredientes),
                'missedIngredients' => []
            ]
        ];
    }
    
    echo json_encode($receitas);
}
?>