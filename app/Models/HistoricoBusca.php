<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoricoBusca extends Model
{
    use HasFactory;

    protected $table = 'historico_busca';
    public $timestamps = false;

    protected $fillable = ['usuario_id', 'receita_id', 'termo_busca', 'created_at'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function receita()
    {
        return $this->belongsTo(Receita::class, 'receita_id', 'id_receita');
    }
}
