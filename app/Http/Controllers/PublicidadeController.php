<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicidadeController extends Controller
{
    public function index()
    {
        return view('publicidade.index');
    }

    public function criar(Request $request)
    {
        $anuncio = [
            'id' => time(),
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'imagem' => $request->imagem,
            'link' => $request->link,
            'tipo' => $request->tipo,
            'status' => 'ativo',
            'data_criacao' => date('Y-m-d H:i:s')
        ];

        $anuncios = json_decode(file_get_contents(storage_path('app/anuncios.json')), true) ?? [];
        $anuncios[] = $anuncio;
        file_put_contents(storage_path('app/anuncios.json'), json_encode($anuncios));

        return response()->json(['success' => true, 'message' => 'Anúncio criado com sucesso!']);
    }

    public function listar()
    {
        $anuncios = json_decode(file_get_contents(storage_path('app/anuncios.json')), true) ?? [];
        return response()->json($anuncios);
    }

    public function atualizar(Request $request, $id)
    {
        $anuncios = json_decode(file_get_contents(storage_path('app/anuncios.json')), true) ?? [];
        
        foreach ($anuncios as &$anuncio) {
            if ($anuncio['id'] == $id) {
                $anuncio['status'] = $request->status;
                break;
            }
        }

        file_put_contents(storage_path('app/anuncios.json'), json_encode($anuncios));
        return response()->json(['success' => true]);
    }

    public function deletar($id)
    {
        $anuncios = json_decode(file_get_contents(storage_path('app/anuncios.json')), true) ?? [];
        $anuncios = array_filter($anuncios, fn($a) => $a['id'] != $id);
        
        file_put_contents(storage_path('app/anuncios.json'), json_encode(array_values($anuncios)));
        return response()->json(['success' => true]);
    }
}