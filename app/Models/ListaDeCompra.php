<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListaCompra extends Model
{
    use HasFactory;

    protected $table = 'lista_compras';
    public $timestamps = false;

    protected $fillable = ['usuario_id', 'receita_id', 'ingrediente', 'quantidade', 'comprado'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function receita()
    {
        return $this->belongsTo(Receita::class, 'receita_id', 'id_receita');
    }
}
