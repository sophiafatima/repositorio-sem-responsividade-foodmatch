<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Usuario;

class ReceitaController extends Controller
{
    public function gerarReceita(Request $request)
    {
        try {
            $ingredientes = $request->get('ingredientes', '');
            $porcoes = $request->get('porcoes', 2);
            
            // Buscar restrições do usuário
            $restricoes = '';
            if (session('usuario_logado')) {
                $usuario = Usuario::where('nome_usuario', session('usuario_logado'))->first();
                if ($usuario && $usuario->restricoes) {
                    $restricoes = $usuario->restricoes;
                }
            }
            
            // Gerar receita com base nos ingredientes, porções e restrições
            $receita = $this->criarReceitaPersonalizada($ingredientes, $porcoes, $restricoes);
            
            return response()->json([
                'success' => true,
                'receita' => $receita
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar receita: ' . $e->getMessage()
            ]);
        }
    }
    
    private function criarReceitaPersonalizada($ingredientes, $porcoes, $restricoes)
    {
        $ingredientesLower = strtolower($ingredientes);
        
        // Aplicar restrições
        $restricoesTexto = '';
        if ($restricoes) {
            $restricoesTexto = " (Adaptado para: $restricoes)";
        }
        
        // Receitas de macarrão
        if (strpos($ingredientesLower, 'macarrão') !== false || strpos($ingredientesLower, 'macarrao') !== false || strpos($ingredientesLower, 'massa') !== false) {
            return $this->gerarReceitaMacarrao($porcoes, $restricoes);
        }
        
        // Receitas específicas com adaptação de porções
        if (strpos($ingredientesLower, 'uva') !== false) {
            return [
                'nome' => 'Sorvete de Uva' . $restricoesTexto,
                'ingredientes' => [
                    ($porcoes * 1) . ' xícara(s) de polpa de uva',
                    ($porcoes * 0.5) . ' lata(s) de leite condensado' . ($this->temRestricao($restricoes, 'lactose') ? ' sem lactose' : ''),
                    ($porcoes * 0.5) . ' lata(s) de creme de leite' . ($this->temRestricao($restricoes, 'lactose') ? ' vegetal' : ''),
                    ($porcoes * 0.25) . ' xícara(s) de açúcar'
                ],
                'modo_preparo' => "1. Bata todos ingredientes no liquidificador\n2. Despeje em recipiente\n3. Leve ao freezer por 2 horas\n4. Bata novamente para quebrar cristais\n5. Congele até endurecer\n6. Sirva em bolas (Rende $porcoes porções)",
                'tempo_preparo' => '4 horas',
                'porcoes' => $porcoes
            ];
        }
        
        if (strpos($ingredientesLower, 'frango') !== false) {
            $ingredientesFrango = [
                ($porcoes * 0.5) . ' peito(s) de frango',
                ($porcoes * 1.5) . ' dente(s) de alho',
                ($porcoes * 0.5) . ' limão(ões)',
                'sal a gosto',
                'pimenta do reino a gosto',
                ($porcoes * 1) . ' colher(es) de azeite'
            ];
            
            if ($this->temRestricao($restricoes, 'vegano') || $this->temRestricao($restricoes, 'vegetariano')) {
                // Substituir frango por proteína vegetal
                $ingredientesFrango[0] = ($porcoes * 200) . 'g de tofu ou proteína de soja';
            }
            
            return [
                'nome' => 'Proteína Grelhada' . $restricoesTexto,
                'ingredientes' => $ingredientesFrango,
                'modo_preparo' => "1. Tempere a proteína com sal e pimenta\n2. Adicione alho amassado e azeite\n3. Esprema o limão por cima\n4. Grelhe por 8 minutos de cada lado\n5. Sirva quente (Rende $porcoes porções)",
                'tempo_preparo' => '30 minutos',
                'porcoes' => $porcoes
            ];
        }
        
        // Receita genérica adaptada
        return [
            'nome' => 'Receita Personalizada' . $restricoesTexto,
            'ingredientes' => [
                "Ingredientes principais: $ingredientes (para $porcoes pessoas)",
                'Temperos a gosto',
                'Azeite ou óleo para cozinhar'
            ],
            'modo_preparo' => "1. Prepare os ingredientes conforme suas preferências\n2. Tempere adequadamente\n3. Cozinhe em fogo médio\n4. Ajuste o sabor conforme necessário\n5. Sirva para $porcoes pessoas",
            'tempo_preparo' => '45 minutos',
            'porcoes' => $porcoes
        ];
    }
    
    private function gerarReceitaMacarrao($porcoes, $restricoes)
    {
        $restricoesTexto = $restricoes ? " (Adaptado para: $restricoes)" : '';
        
        return [
            'nome' => 'Macarrão à Carbonara' . $restricoesTexto,
            'ingredientes' => [
                ($porcoes * 100) . 'g de macarrão espaguete',
                ($this->temRestricao($restricoes, 'vegano') ? ($porcoes * 2) . ' colher(es) de creme vegetal' : ($porcoes * 2) . ' gema(s) de ovo'),
                ($porcoes * 50) . 'g de queijo parmesão ralado' . ($this->temRestricao($restricoes, 'lactose') ? ' sem lactose' : ''),
                ($this->temRestricao($restricoes, 'vegetariano') || $this->temRestricao($restricoes, 'vegano') ? ($porcoes * 100) . 'g de cogumelos fatiados' : ($porcoes * 50) . 'g de bacon em cubos'),
                ($porcoes * 1) . ' dente(s) de alho',
                'Sal e pimenta do reino a gosto',
                ($porcoes * 1) . ' colher(es) de sopa de azeite'
            ],
            'modo_preparo' => $this->temRestricao($restricoes, 'vegano') ? 
                "1. Cozinhe o macarrão em água fervente com sal\n2. Refogue o alho no azeite\n3. Adicione os cogumelos e refogue\n4. Misture o creme vegetal com o queijo vegano\n5. Escorra o macarrão e misture com os cogumelos\n6. Adicione a mistura de creme vegetal\n7. Mexa bem para incorporar\n8. Tempere com sal e pimenta\n9. Sirva imediatamente (Rende $porcoes porções)" :
                "1. Cozinhe o macarrão em água fervente com sal\n2. Refogue o alho no azeite\n3. Adicione o bacon e doure\n4. Misture as gemas com o queijo\n5. Escorra o macarrão e misture com o bacon\n6. Retire do fogo e adicione a mistura de gemas\n7. Mexa rapidamente para não cozinhar as gemas\n8. Tempere com sal e pimenta\n9. Sirva imediatamente (Rende $porcoes porções)",
            'tempo_preparo' => '20 minutos',
            'porcoes' => $porcoes
        ];
    }
    
    private function temRestricao($restricoes, $tipo)
    {
        if (!$restricoes) return false;
        $restricoesLower = strtolower($restricoes);
        return strpos($restricoesLower, $tipo) !== false;
    }

    public function salvarReceita(Request $request)
    {
        $receita = $request->input('receita');
        $arquivo = storage_path('app/public/receitas/' . time() . '.txt');
        file_put_contents($arquivo, $receita);
        return response()->json(['message' => 'Receita salva com sucesso!', 'arquivo' => $arquivo]);
    }
}