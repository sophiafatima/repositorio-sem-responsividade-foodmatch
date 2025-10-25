<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasta extends Model
{
    use HasFactory;

    protected $table = 'pastas';
    protected $primaryKey = 'id_pasta';
    public $timestamps = false;

    protected $fillable = ['id_usuario', 'nome', 'data_criacao'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_pasta', 'id_pasta');
    }
}
