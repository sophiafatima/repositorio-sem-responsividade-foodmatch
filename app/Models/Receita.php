<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receita extends Model
{
    use HasFactory;

    protected $table = 'receitas';
    protected $primaryKey = 'id_receita';
    public $timestamps = true;

    protected $fillable = [
        'nome_receita',
        'descricao_receita',
        'preferencias',
        'restricao',
        'ingredientes',
    ];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_receita', 'id_receita');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'id_receita', 'id_receita');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_receita', 'id_receita');
    }

    public function listasDeCompras()
    {
        return $this->hasMany(ListaCompra::class, 'receita_id', 'id_receita');
    }

    public function historicoBuscas()
    {
        return $this->hasMany(HistoricoBusca::class, 'receita_id', 'id_receita');
    }
}
