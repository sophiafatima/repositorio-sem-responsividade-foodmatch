<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacao';
    protected $primaryKey = 'id_avaliacao';
    public $timestamps = false;

    protected $fillable = ['id_usuario', 'id_receita', 'nota', 'comentario', 'data_avaliacao'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function receita()
    {
        return $this->belongsTo(Receita::class, 'id_receita', 'id_receita');
    }
}
