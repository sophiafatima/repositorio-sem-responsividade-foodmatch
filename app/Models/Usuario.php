<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nome_usuario',
        'email_usuario',
        'senha_usuario',
        'data_criacao',
    ];

    public function receitas()
    {
        return $this->hasMany(Receita::class, 'id_usuario', 'id_usuario');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_usuario', 'id_usuario');
    }

    public function pastas()
    {
        return $this->hasMany(Pasta::class, 'id_usuario', 'id_usuario');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'id_usuario', 'id_usuario');
    }

    public function interacoesIa()
    {
        return $this->hasMany(InteracaoIa::class, 'id_usuario', 'id_usuario');
    }

    public function listasDeCompras()
    {
        return $this->hasMany(ListaCompra::class, 'usuario_id', 'id_usuario');
    }

    public function historicoBuscas()
    {
        return $this->hasMany(HistoricoBusca::class, 'usuario_id', 'id_usuario');
    }

    public function preferencias()
    {
        return $this->hasMany(Preferencia::class, 'usuario_id', 'id_usuario');
    }
}
