<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InteracaoIa extends Model
{
    use HasFactory;

    protected $table = 'interacoes_ia';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id_usuario', 'prompt', 'resposta', 'data'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
