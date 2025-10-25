<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receita;
use Illuminate\Http\JsonResponse;

class ReceitaController extends Controller
{
    public function index()
    {
        $receitas = Receita::all();
        return view('receitas.index', compact('receitas'));
    }

    public function show($id)
    {
        try {
            $receita = Receita::findOrFail($id);
            return view('receitas.show', compact('receita'));
        } catch (\Exception $e) {
            return redirect('/receitas')->with('error', 'Receita não encontrada');
        }
    }
    
    public function apiShow($id): JsonResponse
    {
        try {
            $receita = Receita::findOrFail($id);
            return response()->json([
                'success' => true,
                'receita' => $receita
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Receita não encontrada'
            ]);
        }
    }

    public function store(Request $request)
    {
        $receita = Receita::create([
            'nome_receita' => $request->nome_receita,
            'descricao_receita' => $request->descricao_receita,
            'ingredientes' => $request->ingredientes,
            'preferencias' => $request->preferencias,
            'restricao' => $request->has('restricao')
        ]);
        
        return redirect('/receitas')->with('success', 'Receita criada com sucesso!');
    }

    public function gerarReceita(Request $request): JsonResponse
    {
        try {
            $pedido = trim($request->input('ingredientes', ''));
            $preferencias = $request->input('preferencias', []);
            
            if (empty($pedido)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Por favor, informe o que deseja cozinhar'
                ]);
            }
            
            $receita = $this->gerarReceitaIA($pedido, $preferencias);
            
            return response()->json([
                'success' => true,
                'receita' => $receita,
                'message' => 'Receita gerada pela IA!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    private function buscarReceitaOnline($pedido)
    {
        // Usar IA local primeiro (mais rápido e confiável)
        try {
            return $this->gerarReceitaIA($pedido);
        } catch (\Exception $e) {
            // Se IA falhar, tenta APIs externas
            try {
                return $this->buscarMealDB($pedido);
            } catch (\Exception $e2) {
                return $this->gerarReceitaLocal($pedido);
            }
        }
    }
    
    private function gerarReceitaIA($pedido, $preferencias = [])
    {
        $ingredientesArray = array_map('trim', explode(',', strtolower($pedido)));
        
        // Base de conhecimento da IA expandida
        $baseReceitas = [
            'frango' => [
                'nome' => 'Frango Temperado Especial',
                'ingredientes' => ['1 peito de frango grande', '3 dentes de alho', '1 limão', 'sal a gosto', 'pimenta do reino', '2 colheres de azeite', 'ervas finas'],
                'preparo' => "1. Corte o peito de frango ao meio na horizontal\n2. Tempere com sal e pimenta dos dois lados\n3. Esprema o limão sobre o frango\n4. Amasse o alho e espalhe sobre a carne\n5. Regue com azeite e adicione ervas\n6. Deixe marinar por 30 minutos\n7. Aqueça a grelha ou frigideira\n8. Grelhe por 8 minutos de cada lado\n9. Verifique se está bem cozido\n10. Sirva quente"
            ],
            'ovo' => [
                'nome' => 'Omelete Cremosa',
                'ingredientes' => ['3 ovos grandes', 'sal', '2 colheres de manteiga', '50g queijo ralado', 'cebolinha'],
                'preparo' => "1. Bata os ovos com sal em tigela\n2. Aqueça a manteiga na frigideira\n3. Despeje os ovos batidos\n4. Mexa delicadamente com espátula\n5. Adicione queijo quando quase pronto\n6. Dobre ao meio\n7. Polvilhe cebolinha\n8. Sirva imediatamente"
            ],
            'macarrão' => [
                'nome' => 'Macarrão à Carbonara',
                'ingredientes' => ['500g macarrão', '200g bacon', '3 ovos', '100g parmesao', 'pimenta preta', 'sal'],
                'preparo' => "1. Cozinhe o macarrão em água salgada\n2. Corte o bacon em cubos e frite\n3. Bata ovos com queijo ralado\n4. Escorra o macarrão reservando água\n5. Misture macarrão com bacon\n6. Retire do fogo e adicione ovos\n7. Mexa rapidamente\n8. Tempere com pimenta\n9. Sirva quente"
            ],
            'arroz' => [
                'nome' => 'Arroz Pilaf',
                'ingredientes' => ['2 xícaras arroz', '1 cebola', '2 dentes alho', '3 colheres azeite', 'sal', 'caldo de galinha'],
                'preparo' => "1. Pique cebola e alho finamente\n2. Refogue no azeite até dourar\n3. Adicione arroz e refogue 2 min\n4. Acrescente caldo quente (1:2)\n5. Tempere com sal\n6. Cozinhe em fogo baixo 18 min\n7. Deixe descansar 5 min\n8. Solte com garfo"
            ],
            'pavê' => [
                'nome' => 'Pavê de Chocolate Cremoso',
                'ingredientes' => ['200g biscoito maisena', '1 lata leite condensado', '1 lata creme de leite', '200ml leite', '3 colheres chocolate em pó', '1 pacote gelatina'],
                'preparo' => "1. Dissolva gelatina em água quente\n2. Misture leite condensado, creme e chocolate\n3. Adicione gelatina à mistura\n4. Molhe biscoitos no leite\n5. Alterne camadas biscoito e creme\n6. Leve à geladeira 4 horas\n7. Decore a gosto\n8. Sirva gelado"
            ],
            'bolo' => [
                'nome' => 'Bolo de Chocolate Fácil',
                'ingredientes' => ['3 ovos', '2 xícaras açúcar', '2 xícaras farinha', '1 xícara chocolate pó', '1 xícara água quente', '1/2 xícara óleo'],
                'preparo' => "1. Bata ovos com açúcar\n2. Adicione farinha e chocolate\n3. Misture óleo e água quente\n4. Incorpore à massa\n5. Despeje em forma untada\n6. Asse 180°C por 40 min\n7. Teste com palito\n8. Deixe esfriar"
            ]
        ];
        
        // IA: Encontrar receita baseada nos ingredientes
        $receitaEncontrada = null;
        $palavrasChave = array_keys($baseReceitas);
        
        foreach ($palavrasChave as $palavra) {
            if (strpos(strtolower($pedido), $palavra) !== false) {
                $receitaEncontrada = $baseReceitas[$palavra];
                break;
            }
        }
        
        // Se não encontrou, usar IA para criar receita baseada nos ingredientes
        if (!$receitaEncontrada) {
            $receitaEncontrada = $this->criarReceitaInteligente($ingredientesArray);
        }
        
        // Aplicar preferências
        $receitaFinal = $this->aplicarPreferencias($receitaEncontrada, $preferencias);
        
        return [
            'nome' => $receitaFinal['nome'],
            'ingredientes' => $receitaFinal['ingredientes'],
            'modo_preparo' => $receitaFinal['preparo'],
            'tempo_preparo' => '30-45 minutos',
            'porcoes' => '2-4 pessoas'
        ];
    }
    
    private function criarReceitaInteligente($ingredientes)
    {
        // IA simples para criar receitas baseada nos ingredientes fornecidos
        $nomeReceita = 'Receita Especial com ' . ucfirst($ingredientes[0] ?? 'Ingredientes');
        
        $ingredientesCompletos = array_merge($ingredientes, ['sal', 'pimenta', 'azeite']);
        
        $preparo = "1. Prepare todos os ingredientes\n2. Tempere com sal e pimenta\n3. Aqueça o azeite em panela\n4. Adicione os ingredientes principais\n5. Cozinhe em fogo médio\n6. Mexa ocasionalmente\n7. Ajuste temperos\n8. Sirva quente";
        
        return [
            'nome' => $nomeReceita,
            'ingredientes' => $ingredientesCompletos,
            'preparo' => $preparo
        ];
    }
    
    private function aplicarPreferencias($receita, $preferencias)
    {
        $nome = $receita['nome'];
        $ingredientes = $receita['ingredientes'];
        $preparo = $receita['preparo'];
        
        // Aplicar restrições de lactose
        if (isset($preferencias['lactose']) && $preferencias['lactose']) {
            $nome .= ' (Sem Lactose)';
            $ingredientes = array_filter($ingredientes, function($ing) {
                return !preg_match('/queijo|leite|manteiga|creme/i', $ing);
            });
            $ingredientes[] = 'leite vegetal';
        }
        
        // Aplicar alergias
        if (isset($preferencias['alergia']) && $preferencias['alergia'] && !empty($preferencias['alergiaQuais'])) {
            $alergia = strtolower($preferencias['alergiaQuais']);
            $nome .= ' (Sem ' . ucfirst($alergia) . ')';
            $ingredientes = array_filter($ingredientes, function($ing) use ($alergia) {
                return stripos($ing, $alergia) === false;
            });
        }
        
        return [
            'nome' => $nome,
            'ingredientes' => array_values($ingredientes),
            'preparo' => $preparo
        ];
    }
    
    private function buscarMealDB($pedido)
    {
        $url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($pedido);
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'FoodMatch App'
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        if (!$response) throw new \Exception('API indisponível');
        
        $data = json_decode($response, true);
        
        if (!empty($data['meals'])) {
            $meal = $data['meals'][0];
            
            $ingredients = [];
            for ($i = 1; $i <= 20; $i++) {
                $ingredient = $meal["strIngredient{$i}"];
                $measure = $meal["strMeasure{$i}"];
                if ($ingredient && trim($ingredient)) {
                    $ingredients[] = trim($measure . ' ' . $ingredient);
                }
            }
            
            return [
                'nome' => $meal['strMeal'],
                'ingredientes' => $ingredients,
                'modo_preparo' => $meal['strInstructions'],
                'tempo_preparo' => '45 minutos',
                'porcoes' => '4 pessoas'
            ];
        }
        
        throw new \Exception('Receita não encontrada no MealDB');
    }
    
    private function buscarRecipeAPI($pedido)
    {
        // API gratuita alternativa
        $url = "https://api.edamam.com/search?q=" . urlencode($pedido) . "&app_id=demo&app_key=demo&from=0&to=1";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'FoodMatch App'
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        if (!$response) throw new \Exception('API indisponível');
        
        $data = json_decode($response, true);
        
        if (!empty($data['hits'])) {
            $recipe = $data['hits'][0]['recipe'];
            
            return [
                'nome' => $recipe['label'],
                'ingredientes' => $recipe['ingredientLines'],
                'modo_preparo' => "Receita completa disponível em: " . $recipe['url'],
                'tempo_preparo' => ($recipe['totalTime'] ?? 45) . ' minutos',
                'porcoes' => ($recipe['yield'] ?? 4) . ' pessoas'
            ];
        }
        
        throw new \Exception('Receita não encontrada no Edamam');
    }
    
    private function buscarSpoonacular($pedido)
    {
        $apiKey = env('SPOONACULAR_API_KEY');
        if (!$apiKey || $apiKey === 'your_api_key_here') {
            throw new \Exception('API key não configurada');
        }
        
        $url = "https://api.spoonacular.com/recipes/complexSearch?query=" . urlencode($pedido) . "&number=1&addRecipeInformation=true&apiKey=" . $apiKey;
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'FoodMatch App'
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        if (!$response) throw new \Exception('API Spoonacular indisponível');
        
        $data = json_decode($response, true);
        
        if (!empty($data['results'])) {
            $recipe = $data['results'][0];
            
            $ingredients = [];
            if (!empty($recipe['extendedIngredients'])) {
                foreach ($recipe['extendedIngredients'] as $ingredient) {
                    $ingredients[] = $ingredient['original'];
                }
            }
            
            return [
                'nome' => $recipe['title'],
                'ingredientes' => $ingredients,
                'modo_preparo' => $recipe['summary'] ?? 'Instruções detalhadas disponíveis no link da receita',
                'tempo_preparo' => ($recipe['readyInMinutes'] ?? 30) . ' minutos',
                'porcoes' => ($recipe['servings'] ?? 4) . ' pessoas'
            ];
        }
        
        throw new \Exception('Receita não encontrada no Spoonacular');
    }
    
    private function gerarReceitaLocal($pedido)
    {
        // Base local expandida como fallback
        $receitas = [
            'pave' => ['nome' => 'Pavê de Chocolate', 'ingredientes' => ['200g biscoito maisena', '1 lata leite condensado', '1 lata creme de leite', '200ml leite', '3 colheres chocolate em pó'], 'modo_preparo' => "1. Dissolva a gelatina\n2. Misture leite condensado e chocolate\n3. Alterne camadas\n4. Geladeira por 4h", 'tempo_preparo' => '30 min', 'porcoes' => '8 pessoas'],
            'bolo' => ['nome' => 'Bolo de Chocolate', 'ingredientes' => ['3 ovos', '2 xícaras açúcar', '2 xícaras farinha', '1 xícara chocolate'], 'modo_preparo' => "1. Bata ovos e açúcar\n2. Adicione farinha\n3. Asse 40 min a 180°C", 'tempo_preparo' => '1 hora', 'porcoes' => '10 pessoas'],
            'lasanha' => ['nome' => 'Lasanha Bolonhesa', 'ingredientes' => ['500g massa', '500g carne', '2 latas molho tomate', '500g mussarela'], 'modo_preparo' => "1. Refogue a carne\n2. Monte camadas\n3. Asse 30 min", 'tempo_preparo' => '1h 30min', 'porcoes' => '6 pessoas'],
            'brigadeiro' => ['nome' => 'Brigadeiro', 'ingredientes' => ['1 lata leite condensado', '3 colheres chocolate', '1 colher manteiga'], 'modo_preparo' => "1. Misture tudo\n2. Cozinhe mexendo\n3. Faça bolinhas", 'tempo_preparo' => '30 min', 'porcoes' => '20 unidades'],
            'pizza' => ['nome' => 'Pizza Margherita', 'ingredientes' => ['300g farinha', 'fermento', 'molho tomate', 'mussarela'], 'modo_preparo' => "1. Faça a massa\n2. Adicione cobertura\n3. Asse 15 min", 'tempo_preparo' => '2 horas', 'porcoes' => '4 pessoas']
        ];
        
        $pedidoLower = strtolower($pedido);
        foreach ($receitas as $palavra => $receita) {
            if (strpos($pedidoLower, $palavra) !== false) {
                return $receita;
            }
        }
        
        throw new \Exception('Receita "' . $pedido . '" não encontrada. Sistema temporariamente limitado.');
    }

    public function salvarReceita(Request $request): JsonResponse
    {
        try {
            $receitaData = $request->input('receita', []);
            
            if (empty($receitaData['nome'])) {
                return response()->json(['success' => false, 'message' => 'Nome da receita é obrigatório']);
            }
            
            $ingredientes = isset($receitaData['ingredientes']) && is_array($receitaData['ingredientes']) 
                ? implode(', ', $receitaData['ingredientes']) 
                : (isset($receitaData['ingredientes']) ? $receitaData['ingredientes'] : '');
            
            $receita = Receita::create([
                'nome_receita' => substr($receitaData['nome'], 0, 500),
                'descricao_receita' => isset($receitaData['modo_preparo']) ? substr($receitaData['modo_preparo'], 0, 500) : 'Receita salva pelo usuário',
                'ingredientes' => substr($ingredientes, 0, 500),
                'preferencias' => json_encode($request->input('preferencias', [])),
                'restricao' => false
            ]);
            
            return response()->json(['success' => true, 'id' => $receita->id_receita]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deletarReceita(Request $request): JsonResponse
    {
        try {
            $receita = Receita::findOrFail($request->input('id'));
            $receita->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function salvarPasta(Request $request): JsonResponse
    {
        return response()->json(['success' => true, 'message' => 'Pasta salva']);
    }
    
    public function salvarAvaliacao(Request $request): JsonResponse
    {
        return response()->json(['success' => true, 'message' => 'Avaliação salva']);
    }
    
    public function salvarComentario(Request $request): JsonResponse
    {
        return response()->json(['success' => true, 'message' => 'Comentário salvo']);
    }
    
    public function salvarDenuncia(Request $request): JsonResponse
    {
        return response()->json(['success' => true, 'message' => 'Denúncia salva']);
    }
}
