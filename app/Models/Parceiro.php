<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parceiro extends Model
{
    use HasFactory;

    protected $table = 'parceiros';
    protected $primaryKey = 'id_parceiro';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'tipo',
        'email',
        'telefone',
        'descricao',
        'site_url',
        'data_cadastro',
    ];
}
