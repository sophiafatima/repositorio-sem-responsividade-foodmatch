<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorito extends Model
{
    use HasFactory;

    protected $table = 'favoritos';
    protected $primaryKey = 'id_favorito';
    public $timestamps = false;

    protected $fillable = ['id_pasta', 'id_receita', 'data_favorito'];

    public function pasta()
    {
        return $this->belongsTo(Pasta::class, 'id_pasta', 'id_pasta');
    }

    public function receita()
    {
        return $this->belongsTo(Receita::class, 'id_receita', 'id_receita');
    }
}
    