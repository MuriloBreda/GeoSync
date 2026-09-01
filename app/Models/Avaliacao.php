<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    // Lista apenas os campos existentes na tabela
    protected $fillable = [
        'nome_exibicao',
        'nota',
        'comentario',
    ];
}