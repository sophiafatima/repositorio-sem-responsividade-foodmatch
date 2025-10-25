<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Preferencia extends Model
{
    use HasFactory;

    protected $table = 'preferencias';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'tipo_comida',
        'ingredientes_disponiveis',
        'intolerancias',
        'alergias',
        'created_at',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
}
