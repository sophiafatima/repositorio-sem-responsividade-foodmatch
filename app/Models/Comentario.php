<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';
    protected $primaryKey = 'id_coment';
    public $timestamps = false;

    protected $fillable = [
        'id_receita',
        'id_usuario',
        'texto',
        'data',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function receita()
    {
        return $this->belongsTo(Receita::class, 'id_receita', 'id_receita');
    }
}
